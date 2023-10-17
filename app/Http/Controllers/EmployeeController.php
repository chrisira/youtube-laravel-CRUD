<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //
    public function index(){
        return view('employee.index');
    }
    public function fetch_employees(){
        $employees = Employee::all();
        return response()->json([
            'employees'=>$employees
        ]);
    }
    public function edit($id){
        $employee = Employee::find($id);
        if($employee){
             return response()->json([
                'status'=>200,
                'employee'=>$employee
            ]);
        }
        else{
             return response()->json([
                'status'=>404,
                'message'=>"Employee Not Found!"

            ]);

        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'role'=>'required|max:191',

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()

            ]);
        }
        else
        {
            $employee = new Employee;

            $employee->names = $request->input('name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->role = $request->input('role');
            $employee->save();

            return response()->json([
                'status'=>200,
                'message'=>"Employee Saved Successfully!"

            ]);


        }
    }
    public function update(Request $request,$id){
          $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'role'=>'required|max:191',

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()

            ]);
        }
        else{
            
        $employee = Employee::find($id);
        if($employee){
            $employee->names = $request->input('name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->role = $request->input('role');
            $employee->update();

            return response()->json([
                'status'=>200,
                'message'=>"Employee updated Successfully!"

            ]);
             
        }
        else{
             return response()->json([
                'status'=>404,
                'message'=>"Employee Not Found!"

            ]);

        }

        }

    }
    public function destroy($id){
        $employee = Employee::find($id);
        $employee->delete();
         return response()->json([
                'status'=>200,
                'message'=>"Employee Deleted Successfully!"

            ]);

    }
}
