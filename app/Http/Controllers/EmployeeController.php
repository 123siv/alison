<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with('department')->get();
        $departments = Department::all();

        return view('home.employees.create', compact('employees', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Employee::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'photo' => $photoPath,
        ]);

        return redirect()->route('employees.create')->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('home.employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->name = $request->name;
        $employee->department_id = $request->department_id;
        $employee->phone = $request->phone;
        $employee->dob = $request->dob;

        if ($request->hasFile('photo')) {
            
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $employee->photo = $request->file('photo')->store('photos', 'public');
        }

        $employee->save();

        return redirect()->route('employees.create')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.create')->with('success', 'Employee deleted successfully.');
    }
}
