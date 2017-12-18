<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/14/2017
 * Time: 3:29 PM
 */

namespace App\Modules\Image\Repositories;


use App\Modules\Image\Contracts\RepositoryImageContract;
use App\Modules\Image\Models\Image;

/**
 * Class RepositoryImage
 * @package App\Modules\Image\Services
 */
class RepositoryImage implements RepositoryImageContract
{
    /**
     * @var Image
     */
    private $image;

    /**
     * RepositoryImage constructor.
     *
     * @param $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Get model by primary key
     *
     * @param $id
     * @param array $relationsLoad
     * @param null $relation
     * @return mixed
     * @internal param array $relations
     */
    public function getById($id, $relationsLoad = [], $relation = null)
    {
        $image = $this->image->find($id);

        if($relation){
            return $image->{$relation};
        }

        if(count($relationsLoad) > 0){
            $image->load($relationsLoad);
        }

        return $image;
    }
}