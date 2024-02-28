<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team_tb;
use App\Models\Department_tb;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team_tb::all();
        $departments = Department_tb::all();
        return view('teams.index', compact('teams', 'departments'));
    }

    public function store(Request $request)
    {
        Team_tb::create($request->all());
        return redirect()->route('teams.index');
    }

    public function update(Request $request, $team_id)
    {
        $team = Team_tb::findOrFail($team_id);
        $team->update($request->all());
        return redirect()->route('teams.index');
    }

    public function destroy($team_id)
    {
        Team_tb::findOrFail($team_id)->delete();
        return redirect()->route('teams.index');
    }
}
