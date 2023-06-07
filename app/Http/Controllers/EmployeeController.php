<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Exceptions\ApiException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Employee::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|regex:/^[0-9]{5}$/',
            'salary' => 'required|numeric|between:0,999999.99',
            'hire_date' => 'required|date_format:Y-m-d',
        ]);

        $employee = Employee::create($validatedData);
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $employee = Employee::find($id);
        if (!$employee) {
            throw new ApiException('Employee not found', 404);
        }
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'email' => 'email|unique:employees,email,'.$id,
            'phone' => 'regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
            'zip' => 'regex:/^[0-9]{5}$/',
            'salary' => 'numeric|between:0,999999.99',
            'hire_date' => 'date_format:Y-m-d',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($validatedData);
        return response()->json($employee, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $employee = Employee::find($id);
        if (!$employee) {
            throw new ApiException('Employee not found', 404);
        }
        $employee->delete();
        return response()->json(null, 204);
    }
}
