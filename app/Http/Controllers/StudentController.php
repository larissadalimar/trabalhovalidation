<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\storeStudent;
use App\Http\Requests\updateStudent;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeStudent $request)
    {
        $newStudent = new Student;

        $newStudent->nome = $request->nome;
        $newStudent->idade = $request->idade;
        $newStudent->email = $request->email;
        $newStudent->cpf = $request->cpf;
        $newStudent->telefone = $request->telefone;
        if(!Storage::exists('LocalFiles/')) {
                    Storage::makeDirectory('LocalFiles/', 0775, true);
                }

        $file = base64_decode($request->boletim);
        $fileName = uniqid().'.pdf';
        $path = storage_path('/app/LocalFiles/'.$fileName);
        file_put_contents($path, $file);

        $newStudent->boletim = $fileName;

        $newStudent->save();
        return response()->json('Estudante criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(updateStudent $request, Student $student)
    {
        if($request->nome){
          $student->nome = $request->nome;
        }
        if($request->idade){
          $student->idade = $request->idade;
        }
        if($request->email){
          $student->email = $request->email;
        }
        if($request->cpf){
          $student->cpf = $request->cpf;
        }
        if($request->telefone){
          $student->telefone = $request->telefone;
        }
        if($request->boletim){
            Storage::delete('LocalFiles/'.$student->boletim);
            $file = base64_decode($request->boletim);
            $fileName = uniqid().'.pdf';
            $path = storage_path('/app/LocalFiles/'.$fileName);
            file_put_contents($path, $file);

            $student->boletim = $fileName;

        }

        $student->save();
        return response()->json('Dado(s) do estudante atualizado(s) com sucesso!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Storage::delete('LocalFiles/'.$student->boletim);
        Student::destroy($student->id);
        return response()->json('Estudante deletado com sucesso');
    }

    public function downloadFile($id){
        $student = Student::find($id);
        $filePath = storage_path('app/LocalFiles/'.$student->boletim);
        return response()->download($filePath, $student->boletim);
    }
}
