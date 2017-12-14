<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/14/2017
 * Time: 10:21 AM
 */

namespace App\Modules\Image\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'path'    => 'required|string',
            'deleted' => 'boolean',
        ];
    }
}