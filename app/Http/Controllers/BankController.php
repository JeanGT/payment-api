<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BankController extends Controller
{
    public function reset()
    {
        return response()->json(true, 200);
    }
}
