<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Transfer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function handle(Request $request){        
        DB::beginTransaction();
        
        try {
            switch($request->type){
                case 'deposit':
                    $response = $this->deposit($request);
                    break;
                case 'withdraw':
                    $response = $this->withdraw($request);
                    break;
                case 'transfer':
                    $response = $this->transfer($request);
                    break;
                default:
                    throw new Exception("0", 400);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(intval($e->getMessage()), $e->getCode());
        }

        DB::commit();
        return $response;
    }

    private function deposit(Request $request){
        $validator = Validator::make($request->all(), [
            'destination' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) throw new Exception("0", 400);

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
        $validator = Validator::make($request->all(), [
            'origin' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) throw new Exception("0", 400);

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
        $validator = Validator::make($request->all(), [
            'destination' => 'required|integer',
            'origin' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) throw new Exception("0", 400);

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
