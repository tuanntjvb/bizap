<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Request;

/**
 * UserController
 * Author: trinhnv
 * Date: 2018/07/16 10:24
 */
class UserController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.users';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::users';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = User::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'User';

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function alterValuesToSave(Request $request, $values)
    {
        if (empty($values['password'])) {
            unset($values['password']);
        }

        return $values;
    }

    /**
     * Classes using this trait have to implement this method.
     * Used to validate store.
     *
     * @return array
     */
    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    /**
     * Classes using this trait have to implement this method.
     * Used to validate update.
     *
     * @param $record
     * @return array
     */
    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $record->id,
                'password' => 'confirmed',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

}
