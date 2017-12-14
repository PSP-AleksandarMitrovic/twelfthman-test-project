<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 6:46 PM
 */

namespace App\Common\Contracts;


interface ReadContract
{
    /**
     * Read single entity from database
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function getSingleData($id, $data);

    /**
     * Read entity collection
     *
     * @param $data
     * @return mixed
     */
    public function getCollectionData($data);
}