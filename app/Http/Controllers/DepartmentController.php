<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department_tb;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department_tb::all();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $existingDepartment = Department_tb::find($request->department_id);

        if ($existingDepartment) {
            return back()->withErrors(['department_id' => 'Department ID already exists.'])->withInput();
        }

        Department_tb::create($request->all());
        return redirect()->route('departments.index');
    }

    public function destroy($department_id)
    {
        Department_tb::findOrFail($department_id)->delete();
        return redirect()->route('departments.index');
    }
}
