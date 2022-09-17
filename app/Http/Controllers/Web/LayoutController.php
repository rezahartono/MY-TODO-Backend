<?php

namespace App\Http\Controllers\Web;

use App\DataTables\StateDataTable;
use App\DataTables\UserDatatable;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Task;
use App\Models\TaskTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class LayoutController extends Controller
{
    public function loginView()
    {
        $data = [
            'title' => 'Sign In',
        ];

        return view('authentication.login', $data);
    }

    public function dashboardView()
    {
        $count = [
            'daily_tasks' => Task::whereDate('created_at', Carbon::today())->get()->count(),
            'weekly_tasks' => Task::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count(),
            'total_tasks' => Task::get()->count(),
            'total_users' => User::get()->count(),
        ];

        $tasks =
            Task::with(['subTasks.state'])->whereDate('created_at', Carbon::today())->paginate(5);
        $allowedState = State::whereIn('name', ['Completed', 'Closed'])->get();
        // $subTask = $task->subTasks->whereIn('state_id', [$allowedState[0]->id, $allowedState[1]->id])->count();
        // $percentage = ($subTask * 100) / $task->subTasks->count();

        $data = [
            'title' => 'Dashboard',
            'user' => Auth::user(),
            'count' => $count,
            'tasks' => $tasks,
            'allowedState' => $allowedState
        ];

        return view('pages.dashboard', $data);
    }

    public function usersView(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/reset-password/' . $row->id . '" class="btn btn-primary btn-sm">Reset Password</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $viewData = [
            'title' => 'Users',
            'user' => Auth::user(),
        ];
        return view('pages.users', $viewData);
    }

    public function statesView(Request $request)
    {
        if ($request->ajax()) {
            $data = State::select()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="/master-data/states/' . $row->id . '" method="post">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $viewData = [
            'title' => 'States',
            'user' => Auth::user(),
        ];
        return view('pages.states', $viewData);
    }

    public function tasksView(Request $request)
    {
        if ($request->ajax()) {
            $data = Task::select()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/tasks/' . $row->id . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $viewData = [
            'title' => 'Tasks',
            'user' => Auth::user(),
        ];
        return view('pages.tasks', $viewData);
    }

    public function editTaskView(Request $request, $id)
    {
        $task =
            Task::with(['subTasks.state'])->where('id', '=', $id)->get()->first();

        if ($task == null) {
            return abort(404);
        }

        if ($request->ajax()) {
            $data =
                Task::with(['subTasks.state'])->where('id', '=', $id)->get()->first();
            return Datatables::of($data->subTasks)
                ->make(true);
        }

        $allowedState = State::whereIn('name', ['Completed', 'Closed'])->get();

        $subTask = $task->subTasks->whereIn('state_id', [$allowedState[0]->id, $allowedState[1]->id])->count();
        $percentage = ($subTask * 100) / $task->subTasks->count();


        $viewData = [
            'title' => 'Tasks',
            'user' => Auth::user(),
            'task' => $task,
            'percentage' => $percentage,
        ];
        return view('pages.show_task', $viewData);
        // return response()->json($percentage);
    }
}
