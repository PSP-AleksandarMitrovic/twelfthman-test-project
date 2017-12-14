<?php
/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/14/2017
 * Time: 10:26 AM
 */

namespace App\Modules\Image\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'path'    => 'string',
            'deleted' => 'boolean',
        ];
    }
}