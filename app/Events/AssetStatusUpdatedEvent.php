<?php

namespace App\Events;

use App\Models\Asset;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssetStatusUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Asset $asset)
    {
        //
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
