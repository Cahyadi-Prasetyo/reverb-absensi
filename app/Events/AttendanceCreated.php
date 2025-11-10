<?php

namespace App\Events;

use App\Models\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Attendance $attendance)
    {
        $this->attendance->load('user');
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('attendances'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->attendance->id,
            'user' => [
                'id' => $this->attendance->user->id,
                'name' => $this->attendance->user->name,
                'role' => $this->attendance->user->role,
            ],
            'type' => $this->attendance->type,
            'timestamp' => $this->attendance->timestamp->toISOString(),
            'node_id' => $this->attendance->node_id,
            'created_at' => $this->attendance->created_at->toISOString(),
        ];
    }
}
