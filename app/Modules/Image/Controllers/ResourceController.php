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
use App\Modules\Image\Requests\UpdateRequest;
use App\Modules\Image\Validators\ImageValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @param ImageValidator $validator
     * @return JsonResponse
     */
    public function store(Request $request, ImageValidator $validator): JsonResponse
    {
        try {
            $data = $request->json()->all();

            // Validate against the create ruleset.
            if (!$validator->validate($data, 'create')) {
                return $this->error($validator->getErrors());
            }

            return $this->ok($this->db_cud->store($data), "Image created");
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    /**
     * @param UpdateRequest|Request $request
     * @param ImageValidator $validator
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, ImageValidator $validator, $id): JsonResponse
    {
        try {
            $data = $request->json()->all();

            // Validate against the update ruleset.
            if (!$validator->validate($data, 'update')) {
                return $this->error($validator->getErrors());
            }

            return $this->ok($this->db_cud->update($data, $id), "Image updated");
        } catch (ModelNotFoundException $e) {
            return $this->notOk([], $e->getMessage(), 404);
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $this->db_cud->delete($id);

            return $this->ok([], "Image deleted");
        } catch (ModelNotFoundException $e) {
            return $this->notOk([], $e->getMessage(), 404);
        } catch (Exception $e) {
            return $this->notOk([], $e->getMessage(), 500);
        }
    }
}