<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 2:47 PM
 */

namespace App\Modules\Image\Controllers;

use App\Common\Controllers\ApiController;
use App\Http\Requests\ApiGetRequest;
use App\Modules\Image\Contracts\CUDImageContract;
use App\Modules\Image\Contracts\ReadImageContract;
use App\Modules\Image\Requests\StoreRequest;
use App\Modules\Image\Requests\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class ResourceController extends ApiController
{
    /**
     * @var CUDImageContract
     */
    private $db_cud;

    /**
     * @var ReadImageService
     */
    private $db_read;

    /**
     * ResourceController constructor.
     *
     * @param CUDImageContract $db_cud
     * @param ReadImageContract $db_read
     */
    public function __construct(CUDImageContract $db_cud, ReadImageContract $db_read)
    {
        $this->db_cud = $db_cud;
        $this->db_read = $db_read;
    }


    public function index(ApiGetRequest $request)
    {
        try {
            return $this->ok($this->db_read->getCollectionData($request->all()), "Ok");
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    public function show(ApiGetRequest $request, $id)
    {
        try {
            return $this->ok($this->db_read->getSingleData($id, $request->all()), "Ok");
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        try {
            $data = $request->json()->all();

            return $this->ok($this->db_cud->store($data), "Image created");
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id) : JsonResponse
    {
        try {
            $data = $request->json()->all();

            return $this->ok($this->db_cud->update($data, $id), "Image updated");
        }catch (ModelNotFoundException $e) {
            return $this->notOk([], $e->getMessage(), 404);
        }catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) : JsonResponse
    {
        try {
            $this->db_cud->delete($id);

            return $this->ok([], "Image deleted");
        }catch (ModelNotFoundException $e) {
            return $this->notOk([], $e->getMessage(), 404);
        }catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }
}