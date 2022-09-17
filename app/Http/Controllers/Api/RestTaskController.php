<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RestTaskController extends Controller
{
    public function create(Request $request)
    {
        $user = auth('api')->user();

        $request->validate([
            'title' => ['required', 'max:255'],
            'start_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['date_format:Y-m-d H:i:s'],
        ]);

        $old_number = (Task::get()->count() >= 1) ? (int)Task::select('number')->get()->last()['number'] : 0;

        if ($old_number != null) {
            $new_number = $old_number + 1;
        } else {
            $new_number = 1;
        }

        $task = new Task();
        $task->number = $new_number;
        $task->created_by = $user->id;
        $task->start_at = $request->start_at;
        $task->end_at = $request->end_at;
        $task->title = $request->title;

        $result = $task->save();

        if ($result) {
            return ResponseFormatter::success($request->segment(3), null, "Task Created", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'start_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_at' => ['date_format:Y-m-d H:i:s'],
        ]);

        $task = Task::where('id', '=', $id)->first();
        $task->start_at = $request->start_at;
        $task->end_at = $request->end_at;
        $task->title = $request->title;

        $result = $task->update();

        if ($result) {
            return ResponseFormatter::success($request->segment(3), null, "Task Updated!", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }

    public function delete(Request $request, $id)
    {
        $task = Task::where('id', '=', $id)->first();
        $result = $task->delete();

        if ($result != null) {
            return ResponseFormatter::success($request->segment(3), null, "Task Deleted!", 200,);
        } else {
            return ResponseFormatter::error($request->segment(3), null, "Error Occured!", 400, "Bad Request");
        }
    }
}
