<?php

namespace App\Modules\Image\Validators;

use App\Common\Validators\BaseValidator;

/**
 * Created by PhpStorm.
 * User: Backend
 * Date: 12/18/2017
 * Time: 10:42 AM
 */
class ImageValidator extends BaseValidator
{
    /**
     * Validation rules for this Validator.
     *
     * @var array
     */
    protected $rules = [

        'create' => [
            'path' => 'required|string',
            'deleted' => 'boolean',
        ],

        'update' => [
            'path' => 'string',
            'deleted' => 'boolean',
        ]
    ];
}