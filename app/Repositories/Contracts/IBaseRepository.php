<?php //app/Repositories/Contracts/BaseRepository.php
namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    /**
     * Find a resource by id
     *
     * @param $id
     *
     * @return Model|null
     */
    public function findOne($id);

    /**
     * Find a resource by criteria
     *
     * @param array $criteria
     *
     * @return Model|null
     */
    public function findOneBy(array $criteria);

    /**
     * Search All resources by criteria
     *
     * @param array $searchCriteria
     * @param bool  $all
     *
     * @return Collection
     */

    public function findBy(array $searchCriteria = [], $all = false);

    /**
     * Search All resources by any values of a key
     *
     * @param string $key
     * @param array  $values
     *
     * @return Collection
     */
    public function findIn($key, array $values);

    /**
     * Save a resource
     *
     * @param array $data
     *
     * @return Model
     */
    public function save(array $data);

    /**
     * Update a resource
     *
     * @param Model $model
     * @param array $data
     *
     * @return Model
     */
    public function update(Model $model, array $data);

    /**
     * Delete a resource
     *
     * @param Model $model
     *
     * @return mixed
     */
    public function delete(Model $model);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function multiInsert(array $data);

    /**
     * @param array $conditions
     * @param array $data
     *
     * @return mixed
     */
    public function multiUpdate(array $conditions, array $data);


    /**
     * @param array $conditions
     * @param bool  $forceDelete
     *
     * @return mixed
     */
    public function multiDelete(array $conditions, bool $forceDelete = false);

}
