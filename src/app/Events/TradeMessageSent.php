<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\TradeMessage;

class TradeMessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $tradeMessage;

    public function __construct(TradeMessage $tradeMessage)
    {
        $this->tradeMessage = $tradeMessage;
    }

    public function broadcastOn()
    {
        return new Channel('trade.' . $this->tradeMessage->item_id);
    }
}

