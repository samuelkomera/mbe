<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'DESC')->pluck('val');
        return response()->json(json_decode($employees,true));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employeeName =(object) [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
        ];
        $employeeInfo =(object) [
              'id'          =>  null,
              'name'        =>  $employeeName,
              'phonenumber' => $request->get('phonenumber'),
              'email'       => $request->get('email')
        ];
        $employee = new Employee([
          'first'     =>  $request->get('first'),
          'last'      =>  $request->get('last'),
          'val'       =>  json_encode($employeeInfo, true)
        ]);
        $employee->save();
        DB::table('employees') ->where('id', $employee->id)->update(['val->id' => $vendor->id]);
        return response()->json(['message' => 'Successfully Added New Staff']);

    }
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }
    public function update(Request $request, $id)
    {
        $employeeName =(object) [
              'first'     =>  $request->get('first'),
              'last'      =>  $request->get('last'),
        ];
        $employeeInfo =(object) [
              'id'        =>  $id,
              'name'      =>  $employeeName,
              'phonenumber'=> $request->get('phonenumber'),
              'email'      => $request->get('email')
        ];
        $employee = new Employee([
          'first'     =>  $request->get('first'),
          'last'      =>  $request->get('last'),
          'val'       =>  json_encode($employeeInfo, true)
        ]);
        Employee::where('id', $id)->update($employee);
        return response()->json([
            'message' => 'Successfully Updated Employee member'
        ]);
    }
    public function destroy($id)
    {  
        Employee::find($id)->delete();
        return response()->json([
            'message' => 'Successfully deleted Employee'
        ]);

    } 
}
