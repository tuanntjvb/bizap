<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class GenerateNormal extends Command
{
    const MODULE_LOWER_CASE = 'module';
    const MODULE_TITLE_CASE = 'Module';
    const TABLE = 'table';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make-module {module} {table} {--skip-route}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository contract for model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument(self::MODULE_LOWER_CASE);
        $table_name = $this->argument(self::TABLE);
        $skip_route = $this->option('skip-route');

        //get fillable column
        $list_column = Schema::getColumnListing($table_name);


        $Module = ucfirst(camel_case($module));
        $contract_tpl = $this->loadView('command.generate_normal.contract', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module]);
        $eloquent_tpl = $this->loadView('command.generate_normal.eloquent', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module]);
        $service_contract_tpl = $this->loadView('command.generate_normal.service_contract', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module]);
        $service_tpl = $this->loadView('command.generate_normal.service', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module]);
        $transformer_tpl = $this->loadView('command.generate_normal.transformer', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module]);
        $model_tpl = $this->loadView('command.generate_normal.model', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module, self::TABLE => $table_name, 'list_column' => $list_column]);
        $controller_tpl = $this->loadView('command.generate_normal.controller', [self::MODULE_LOWER_CASE => $module, self::MODULE_TITLE_CASE => $Module, self::TABLE => $table_name]);

        //create file
        //model
        file_put_contents(app_path('Models/' . $Module . '.php'), $model_tpl);
        file_put_contents(app_path('Repositories/Contracts/I' . $Module . 'Repository.php'), $contract_tpl);
        file_put_contents(app_path('Repositories/' . $Module . 'Repository.php'), $eloquent_tpl);
        file_put_contents(app_path('Transformers/' . $Module . 'Transformer.php'), $transformer_tpl);
        file_put_contents(app_path('Services/Contracts/I' . $Module . 'Service.php'), $service_contract_tpl);
        file_put_contents(app_path('Services/' . $Module . 'Service.php'), $service_tpl);
        if (!$skip_route) {
            file_put_contents(app_path('Http/Controllers/Admin/' . $Module . 'Controller.php'), $controller_tpl);
        }

        //append to RepositoryServiceProvider
        $repo = $Module . 'Repository';
        $string_bind = '		$this->app->bind(I' . $repo . '::class, function () {
			return new ' . $repo . '(new ' . $Module . '());
		});';

        $string_use = 'use App\Repositories\Contracts' . '\I' . $repo . ';' . "\n";
        $string_use .= 'use App\Repositories\\' . $repo . ';' . "\n";
        $string_use .= 'use App\Models\\' . $Module . ';';

        $string_provides = '			' . $repo . '::class,';

        $file_path = app_path('Providers/RepositoriesServiceProvider.php');
        $bind_marker = '##AUTO_INSERT_BIND##';
        $use_marker = '##AUTO_INSERT_USE##';
        $provide_marker = '##AUTO_INSERT_NAME##';
        $this->insertIntoFile($file_path, $bind_marker, $string_bind, true);
        $this->insertIntoFile($file_path, $use_marker, $string_use, true);
        $this->insertIntoFile($file_path, $provide_marker, $string_provides, true);

        //append route
        if (!$skip_route) {
            $route_path = app_path() . '/../' . 'routes/admin.php';
            $route_marker = '##AUTO_INSERT_ROUTE##';
            $route_insert_text = '
		//' . $module . '
		Route::resource(\'' . $module . '\', \'' . $Module . 'Controller\');
		';
            $this->insertIntoFile($route_path, $route_marker, $route_insert_text);
        }

    }

    private function loadView($view, $data = [])
    {
        return '<?php ' . PHP_EOL . view($view, $data);
    }

    private function insertIntoFile($file_path, $insert_marker, $text, $after = true)
    {
        $contents = file_get_contents($file_path);
        $new_contents = str_replace($insert_marker, ($after) ? $insert_marker . "\n" . $text : $text . "\n" . $insert_marker, $contents);
        return file_put_contents($file_path, $new_contents);
    }
}
