<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/13/2017
 * Time: 2:35 PM
 */

namespace App\Common\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiController
 * @package App\Common\Controllers
 */
class ApiController extends Controller
{
    /**
     * Calls Response function with static status code 200, and data that should be returned
     *
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($data = [], $message = 'Done') : JsonResponse
    {
        return $this->response($data, $message);
    }

    /**
     * Returns and formats the responses which return sort of result (all except Errors)
     *
     * @param mixed $data
     * @param string $response_message
     * @param integer $status_code
     * @param bool $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($data, $response_message, $status_code = 200, $status = true) : JsonResponse
    {
        $message['status'] = $status;

        if (isset($message)) {
            $message['message'] = $response_message;
        }

        if (isset($data)) {
            $message['data'] = $data;
        }

        return response()->json($message, $status_code, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Calls Response function with static status code 200, and data that should be returned
     *
     * @param array $data
     * @param string $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function notOk($data = [], $message = 'Done', $code) : JsonResponse
    {
        return $this->response($data, $message, $code, false);
    }

    /**
     * Calls Response function when user errors occurs
     *
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($data = [], $code = 400) : JsonResponse
    {
        $message['status'] = false;

        if (isset($data)) {
            $message['errors'] = $data;
        }

        return response()->json($message, $code, [], JSON_NUMERIC_CHECK);
    }
}