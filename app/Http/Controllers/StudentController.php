<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;



class StudentController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'name' => "required",
            'roll' => "required"
        ]);

        $data = new Student();
        $data->name = $request->name;
        $data->roll = $request->roll;
        $data->save();
        return response()->json($data);
    }
    
    public function show(){
        $data = Student::latest()->get();
        return response()->json($data);
    }

    public function edit($id){
        $data = Student::find($id);
        return response()->json($data);
    }

    public function update(Request $request) {
        $data = Student::find($request->id);
        $data->name = $request->name;
        $data->roll = $request->roll;
        $data->save();
        return response()->json($data);
    }

}
