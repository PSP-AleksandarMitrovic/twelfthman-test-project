<?php

namespace App\Modules\FileSystem\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use StdClass;

/**
 * Class MakeResizedImagesEvent
 * @package App\Modules\FileSystem\Events
 * @property StdClass $data
 */
class MakeResizedImagesEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var StdClass
     */
    public $data;
    /**
     * Create a new event instance.
     */
    public function __construct(StdClass $data)
    {
        $this->data = $data;
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
