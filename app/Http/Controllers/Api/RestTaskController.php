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
            'title' => ['required', 'max:255']
        ]);

        $old_number = (int)Task::select('number')->get()->last()['number'];

        if ($old_number != null) {
            $new_number = $old_number + 1;
        } else {
            $new_number = 1;
        }

        $task = new Task();
        $task->number = $new_number;
        $task->title = $request->title;

        $task->save();

        $tr_task = new TaskTransaction();
        $tr_task->user_id = $user->id;
        $tr_task->task_id = $task->id;
        $tr_task->save();


        return;
        ResponseFormatter::success($request->segment(3), null, "Task Created", 200,);
    }
}
