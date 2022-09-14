<?php

namespace App\Http\Controllers\Web;

use App\DataTables\StateDataTable;
use App\DataTables\UserDatatable;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\User;
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
            'total_users' => User::get()->count(),
        ];

        $data = [
            'title' => 'Dashboard',
            'user' => Auth::user(),
            'count' => $count,
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
                ->make(true);
        }

        $viewData = [
            'title' => 'States',
            'user' => Auth::user(),
        ];
        return view('pages.states', $viewData);
    }
}
