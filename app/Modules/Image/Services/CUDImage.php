<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 3:03 PM
 */

namespace App\Modules\Image\Services;


use App\Modules\Image\Contracts\CUDImageContract;
use App\Modules\Image\Models\Image;

/**
 * Class CRUDImage
 * @package App\Modules\Image\Services
 */
class CUDImage implements CUDImageContract
{
    /**
     * @var Image
     */
    private $model;

    /**
     * CRUDImage constructor.
     * @param $model
     */
    public function __construct(Image $model)
    {
        $this->model = $model;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        // Create image
        $image = $this->model->create($data);

        // ... then create versions for that image
        // Paths will have appended _M and _T markers
        $image->versions()->create([
            ["path" => substr_replace($image->path, "_M", strrpos($image->path, "."), 0)],
            ["path" => substr_replace($image->path, "_T", strrpos($image->path, "."), 0)]
        ]);

        return $image;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($data, $id)
    {
        // If Image is not found, throw 404
        $image = $this->model->findOrFail($id);

        $image->update($data);

        return $image->fresh();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        // If Image is not found, throw 404
        $image = $this->model->findOrFail($id);

        $image->delete();
    }
}