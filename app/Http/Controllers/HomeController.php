<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function redirectToTeams()
    {
        return redirect()->route('teams.index');
    }

    public function redirectToDepartments()
    {
        return redirect()->route('departments.index');
    }
}
