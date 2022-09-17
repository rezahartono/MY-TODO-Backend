<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class MasterDataController extends Controller
{
    public function createState(Request $request)
    {
        $request->validate([
            'name_state' => 'required|max:50'
        ]);

        $state = new State();
        $state->name = $request->name_state;
        $result = $state->save();

        if ($result) {
            Alert::success('Success', 'New State has been added!');
            return redirect(url()->current());
        }
    }

    public function deleteState($id)
    {
        $result = State::where('id', '=', $id)->delete();

        if ($result != null) {
            Alert::success('Success', 'State has been deleted!');
            return redirect('master-data/states');
        }
    }
}
