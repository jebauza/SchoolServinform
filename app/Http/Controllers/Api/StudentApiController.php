<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::name($request->name)
                ->courseId($request->course)
                ->with('courses')
                ->orderBy('name')
                ->get();

        StudentResource::withoutWrapping();
        return StudentResource::collection($students);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $students = Student::name($request->name)
                ->course($request->course)
                ->with('courses')
                ->orderBy('name')
                ->paginate();

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        try {
            DB::beginTransaction();

            $newStudent = new Student($request->all());
            if ($newStudent->save()) {
                $newStudent->courses()->attach($request->courses);
            }

            DB::commit();
            return response()->json([
                'ok' => true,
                'message'=>'Save successfully',
                'student'=> new StudentResource($newStudent)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$student = Student::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        if (!$student = Student::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $student->fill($request->all());
            if ($student->save()) {
                $student->courses()->sync($request->courses);
            }

            DB::commit();
            return response()->json([
                'ok' => true,
                'message'=>'Save successfully',
                'student'=> new StudentResource($student)
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$student = Student::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'ok' => true,
            'message'=>'Save successfully',
            'student'=> new StudentResource($student)
        ]);
    }
}
