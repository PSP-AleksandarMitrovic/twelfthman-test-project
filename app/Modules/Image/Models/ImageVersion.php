<?php

namespace App\Modules\Image\Models;

use App\Common\Models\BaseModel;

/**
 * Class ImageVersion
 * @package App\Modules\Image\Models
 */
class ImageVersion extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'images_versions';

    /**
     * @var array
     */
    protected $fillable = ['path', 'image_id'];

    /**
     * @var array
     */
    protected $relatedModels = ['image'];

    /**
     * Image relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
