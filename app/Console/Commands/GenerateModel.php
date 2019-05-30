<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class GenerateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make-model {name} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

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
		$module = $this->argument('name');
		$table_name = $this->argument('table');

		//get fillable column
		$list_column = Schema::getColumnListing($table_name);


		$Module = ucfirst(camel_case($module));
		$model_tpl = $this->loadView('command.generate_repo.model',['module'=>$module,'Module'=>$Module,'table'=>$table_name, 'list_column'=>$list_column]);

		//create file
		//model
		file_put_contents( app_path('Models/'. $Module.'.php') ,$model_tpl);

    }

    private function loadView($view,$data = []) {
    	return '<?php ' . PHP_EOL . view($view,$data);
	}


}
