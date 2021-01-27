<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;

class CourseApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::name($request->name)
                ->student($request->student)
                ->with('students')
                ->orderBy('name')
                ->get();

        CourseResource::withoutWrapping();
        return CourseResource::collection($courses);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $courses = Course::name($request->name)
                ->student($request->student)
                ->with('students')
                ->orderBy('name')
                ->paginate();

        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            DB::beginTransaction();

            $newCourse = new Course($request->all());
            if ($newCourse->save()) {
                $newCourse->students()->attach($request->students);
            }

            DB::commit();
            return response()->json([
                'ok' => true,
                'message'=>'Save successfully',
                'course'=> new CourseResource($newCourse)
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
        if (!$course = Course::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        return new StudentResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        if (!$course = Course::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $course->fill($request->all());
            if ($course->save()) {
                $course->students()->sync($request->students);
            }

            DB::commit();
            return response()->json([
                'ok' => true,
                'message'=>'Save successfully',
                'course'=> new CourseResource($course)
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 500);
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
        if (!$course = Course::find($id)) {
            return response()->json([
                'ok' => false,
                'message' => 'Not found'
            ], 404);
        }

        $course->delete();

        return response()->json([
            'ok' => true,
            'message'=>'Save successfully',
            'course'=> new CourseResource($course)
        ], 200);
    }
}
