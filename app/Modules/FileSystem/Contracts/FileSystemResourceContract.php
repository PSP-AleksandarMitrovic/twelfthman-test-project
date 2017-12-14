<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 11:41 AM
 */

namespace App\Modules\FileSystem\Contracts;

use Illuminate\Http\Request;

interface FileSystemResourceContract
{
    /**
     * Return specific file
     *
     * @param Request $request
     * @param $bucket
     * @param $fileName
     * @return mixed
     */
    public function get(Request $request, $bucket, $fileName);

    /**
     * Store file
     *
     * @param Request $request
     * @param $bucket
     * @param $fileName
     * @return mixed
     */
    public function put(Request $request, $bucket, $fileName);

    /**
     * Set storage disk
     *
     * @param string $bucket
     * @return mixed
     */
    public function setDisk($bucket = '');
}