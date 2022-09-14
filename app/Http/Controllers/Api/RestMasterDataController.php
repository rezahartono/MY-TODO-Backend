<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class RestMasterDataController extends Controller
{
    public function getStates(Request $request)
    {
        $states = State::get();
        return ResponseFormatter::success($request->segment(3), $states, "You are has been logged out!", 200,);
    }
}
