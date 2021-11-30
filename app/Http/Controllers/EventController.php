<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        return response()->json(true, 200);
    }

    private function withdraw(Request $request){
        return response()->json(true, 200);
    }

    private function transfer(Request $request){
        return response()->json(true, 200);
    }
}
