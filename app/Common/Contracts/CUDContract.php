<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 2:45 PM
 */

namespace App\Common\Contracts;


/**
 * Interface CRUDContract
 * @package App\Common\Contracts
 */
interface CUDContract
{
    /**
     * @param $data
     * @return mixed
     */
    public function store($data);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}