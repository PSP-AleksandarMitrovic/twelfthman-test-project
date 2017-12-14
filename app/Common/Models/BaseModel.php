<?php

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Model
 * @property array $relations
 */
abstract class BaseModel extends Model
{
    /**
     * @var array
     */
    protected $relatedModels = [];

    /**
     * Names of relationships
     *
     * @return array
     */
    public function relationships()
    {
        return $this->relatedModels;
    }
}
