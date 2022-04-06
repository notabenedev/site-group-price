<?php

namespace Notabenedev\SiteGroupPrice\Events;

use App\Group;
use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PriceListChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $group;

    /**
     * Create a new event instance.
     *
     * @param Group $group
     * @return void
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

}
