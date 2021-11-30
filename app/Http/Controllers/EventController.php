<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function handle(Request $request){        
        switch($request->type){
            case 'deposit':
                return $this->deposit($request);
            case 'withdraw':
                return $this->withdraw($request);
            case 'transfer':
                return $this->transfer($request);
            default:
                //throw an exception
        }
    }

    private function deposit(Request $request){
        $transaction = Transaction::createTransaction([
            'type' => 'deposit',
            'value' => $request->amount,
            'account_id' => $request->destination
        ]);

        $destination = $transaction->account;
        
        return response()->json([
            'destination' => $destination->getInfo()
        ], 201);
    }

    private function withdraw(Request $request){
        $transaction = Transaction::createTransaction([
            'type' => 'withdraw',
            'value' => $request->amount,
            'account_id' => $request->origin
        ]);

        $origin = $transaction->account;
        
        return response()->json([
            'origin' => $origin->getInfo()
        ], 201);
    }

    private function transfer(Request $request){
        $transfer = Transfer::createTransfer([
            'value' => $request->amount,
            'account_from' => $request->origin,
            'account_to' => $request->destination,
        ]);

        $origin = $transfer->from;
        $destination = $transfer->to;

        return response()->json([
            'origin' => $origin->getInfo(),
            'destination' => $destination->getInfo()
        ], 201);
    }
}
