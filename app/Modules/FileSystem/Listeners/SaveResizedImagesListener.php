<?php

namespace App\Modules\FileSystem\Listeners;

use App\Modules\FileSystem\Events\SaveResizedImagesEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class SaveResizedImagesListener
{
    /**
     * Handle the event.
     *
     * @param  SaveResizedImagesEvent  $event
     * @return void
     */
    public function handle(SaveResizedImagesEvent $event)
    {
        // Storage used for public saving version images
        Storage::disk('public')->put($event->path, $event->image->stream());
    }
}
