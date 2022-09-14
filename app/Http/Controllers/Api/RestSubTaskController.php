<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestSubTaskController extends Controller
{
    public function create(Request $request)
    {
        $validated = Validator::make(
            $request->only('description', 'state_id', 'start_at', 'end_at'),
            [
                'description' => 'required|max:255',
                'state_id' => 'required',
                'stat_at' => 'required|datetime',
                'end_at' => 'datetime',
            ],
        );
    }
}
