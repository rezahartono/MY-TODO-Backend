<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\SubTask;
use App\Models\TaskTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestSubTaskController extends Controller
{
    public function create(Request $request)
    {
        $user = auth('api')->user();

        $validator = Validator::make(
            $request->only('description', 'state_id', 'task_id', 'start_at', 'end_at'),
            [
                'description' => 'required|max:255',
                'state_id' => 'required',
                'task_id' => 'required',
                'start_at' => 'required|date|date_format:Y-m-d H:i:s',
                'end_at' => 'date|date_format:Y-m-d H:i:s',
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subTask = new SubTask();
        $subTask->description = $request->description;
        $subTask->created_by = $user->id;
        $subTask->task_id = $request->task_id;
        $subTask->state_id = $request->state_id;
        $subTask->start_at = $request->start_at;
        $subTask->end_at = $request->end_at;
        $result = $subTask->save();

        if ($result) {
            return ResponseFormatter::success($request->segment(3), null, "Sub Task Created", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->only('description', 'state_id', 'task_id', 'start_at', 'end_at'),
            [
                'description' => 'required|max:255',
                'state_id' => 'required',
                'start_at' => 'required|date|date_format:Y-m-d H:i:s',
                'end_at' => 'date|date_format:Y-m-d H:i:s',
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subTask = SubTask::where('id', '=', $id)->first();
        $subTask->description = $request->description;
        $subTask->state_id = $request->state_id;
        $subTask->start_at = $request->start_at;
        $subTask->end_at = $request->end_at;
        $result = $subTask->update();

        if ($result) {
            return ResponseFormatter::success($request->segment(3), null, "Sub Task Updated!", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }

    public function delete(Request $request, $id)
    {
        $subTask = SubTask::where('id', '=', $id)->first();
        $result = $subTask->delete();

        if ($result != null) {
            return ResponseFormatter::success($request->segment(3), null, "Sub Task Deleted!", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }
}
