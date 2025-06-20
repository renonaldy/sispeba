<?php

namespace App\Events;

use App\Models\Pengiriman;
use App\Models\PengirimanStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TrackingUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $status;

    public function __construct(PengirimanStatus $status)
    {
        //
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('tracking.' . $this->status->pengiriman->no_resi)
        ];
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status->status,
            'lokasi_terakhir' => $this->status->lokasi_terakhir,
            'waktu_update' => $this->status->updated_at->toDateTimeString(),
        ];
    }
}
