<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function getBalance(Request $request){
        $account = Account::find($request->account_id);

        if(!$account) return response()->json(0, 404);

        return response()->json($account->balance, 200);
    }
}
