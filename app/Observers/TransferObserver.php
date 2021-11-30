<?php

namespace App\Observers;

use App\Models\Transfer;

class TransferObserver
{
    public function created(Transfer $transfer)
    {
        $transfer->from->balance -= $transfer->value;
        $transfer->to->balance += $transfer->value;

        $transfer->from->save();
        $transfer->to->save();
    }

    public function updated(Transfer $transfer)
    {
        $value_diff = $transfer->value - $transfer->getOriginal('value');

        $transfer->from->balance -= $value_diff;
        $transfer->to->balance -= $value_diff;

        $transfer->from->balance->save();
        $transfer->to->balance->save();
    }


    public function deleted(Transfer $transfer)
    {
        $transfer->from->balance += $transfer->value;
        $transfer->to->balance -= $transfer->value;

        $transfer->from->save();
        $transfer->to->save();
    }
}
