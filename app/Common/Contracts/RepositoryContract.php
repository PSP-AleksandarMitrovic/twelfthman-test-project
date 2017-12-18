<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/14/2017
 * Time: 3:27 PM
 */

namespace App\Common\Contracts;


interface RepositoryContract
{
    /**
     * Get model by primary key
     *
     * @param $id
     * @param array $relationsLoad
     * @param null $relation
     * @return mixed
     * @internal param array $relations
     */
    public function getById($id, $relationsLoad = [], $relation = null);
}