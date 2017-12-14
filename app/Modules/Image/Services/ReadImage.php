<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 6:39 PM
 */

namespace App\Modules\Image\Services;

use App\Common\Services\ApiGetService;
use App\Modules\Image\Contracts\ReadImageContract;
use App\Modules\Image\Models\Image;
use Exception;

/**
 * Class ReadImage
 * @package App\Modules\Image\Services
 */
class ReadImage extends ApiGetService implements ReadImageContract
{
    /**
     * ReadImage constructor.
     * @param Image $model
     */
    public function __construct(Image $model)
    {
        $this->builder = $model->query();
    }

    /**
     * Retrieve single image
     *
     * @param $id
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function getSingleData($id, $data)
    {
        try {
            $this->setApiQuery($data);

            $this->prepareFields();

            return $this->loadRelations()
                ->prepareSingle($id)
                ->setSelectFields()
                ->getSingle();

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Retrieve collection of images
     *
     * @param $data
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function getCollectionData($data)
    {
        try {
            $this->setApiQuery($data);

            $this->prepareFilters();

            $this->prepareFields();

            return $this->loadRelations()
                ->setWhereFilters()
                ->setSortFilters()
                ->setSelectFields()
                ->getData();

        } catch (Exception $e) {
            throw $e;
        }
    }
}