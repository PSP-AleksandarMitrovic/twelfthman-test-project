<?php

namespace App\Modules\FileSystem\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Intervention\Image\Image;

/**
 * Class SaveResizedImagesEvent
 * @package App\Modules\FileSystem\Events
 */
class SaveResizedImagesEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Image
     */
    public $image;

    /**
     * @var string
     */
    public $path;

    /**
     * Create a new event instance.
     * @param string $path
     * @param Image $image
     */
    public function __construct(string $path, Image $image)
    {
        $this->image = $image;
        $this->path = $path;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
