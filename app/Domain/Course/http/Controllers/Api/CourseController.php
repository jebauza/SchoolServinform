<?php
namespace Domain\Course\http\Controllers\Api;

use Illuminate\Http\Request;
use Domain\Course\Models\Course;
use Domain\Course\DTO\CourseData;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Domain\Course\Actions\CreateCourseAction;
use Domain\Course\http\Requests\CourseRequest;
use Domain\Course\http\Resources\CourseResource;
use Domain\Student\http\Resources\StudentResource;

class CourseController extends Controller
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
    public function store(CourseRequest $request, CreateCourseAction $action)
    {
        try {
            DB::beginTransaction();

            $data = CourseData::fromRequest($request);

            $newCourse = $action($data);

            DB::commit();
            return response()->json([
                'ok' => true,
                'message'=>'Save successfully',
                'student'=> new CourseResource($newCourse)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
