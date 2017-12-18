<?php

namespace App\Modules\FileSystem\Listeners;

use App\Modules\FileSystem\Events\MakeResizedImagesEvent;
use App\Modules\FileSystem\Events\SaveResizedImagesEvent;
use App\Modules\Image\Contracts\RepositoryImageContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

/**
 * Class MakeResizedImagesListener
 * @package App\Modules\FileSystem\Listeners
 */
class MakeResizedImagesListener
{
    /**
     * @var ImageManager
     */
    private $intervention;

    /**
     * @var RepositoryImageContract
     */
    private $imageRepository;

    /**
     * @var Image
     */
    private $originalPhoto;

    /**
     * @var UploadedFile
     */
    private $uploadedPhoto;

    /**
     * MakeResizedImagesListener constructor.
     *
     * @param ImageManager $intervention
     * @param RepositoryImageContract $imageRepository
     */
    public function __construct(ImageManager $intervention, RepositoryImageContract $imageRepository)
    {
        $this->intervention = $intervention;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Handle the event.
     *
     * @param  MakeResizedImagesEvent  $event
     * @return void
     */
    public function handle(MakeResizedImagesEvent $event)
    {
        // Build uploaded file
        $this->buildUploadedPhoto($event->data->file);
        // Build Intervention
        $this->buildOriginalImage($event->data->file);
        // Get all image versions
        $imageVersions = $this->imageRepository
            ->getById($event->data->image_id, [], "versions");

        if($imageVersions->count() == 0) {
            return;
        }

        // ... and delegate saving images
        // to next listener
        foreach($imageVersions as $version) {
            // Send BLOB to listener to save it
            event(new SaveResizedImagesEvent($version->path, $this->buildVersionImage($version->type)));
        }
    }

    /**
     * Build Intervention wrapper
     *
     * @param $file
     */
    private function buildOriginalImage($file)
    {
        $this->originalPhoto = $this->intervention->make($file);
    }

    /**
     * Set uploaded photo
     *
     * @param $file
     */
    private function buildUploadedPhoto($file)
    {
        $this->uploadedPhoto = $file;
    }

    /**
     * @param $version
     * @return Image
     */
    private function buildVersionImage($version)
    {
        // Get new width for smaller photo
        $newWidth = $this->calculateImageSize($version);

        // ...and return resized photo
        return $this->intervention->make($this->uploadedPhoto)
            ->resize($newWidth, null, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
    }

    /**
     * Calculate new image width
     *
     * @param $image_type
     * @return int
     * @internal param $width_resize_percentage
     */
    private function calculateImageSize($image_type)
    {
        return ceil((config("image_constants.{$image_type}_image_resize") / 100) * $this->originalPhoto->getWidth());
    }
}
