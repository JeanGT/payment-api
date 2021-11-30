<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function handle(Request $request){        
        return response()->json(true, 200);
    }
}
