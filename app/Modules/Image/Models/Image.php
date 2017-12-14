<?php

namespace App\Modules\Image\Models;

use App\Common\Models\BaseModel;

/**
 * Class Image
 * @package App\Modules\Image\Models
 */
class Image extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['path', 'deleted'];

    /**
     * @var array
     */
    protected $relatedModels = ['versions'];

    /**
     * Image versions relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(ImageVersion::class);
    }

}
