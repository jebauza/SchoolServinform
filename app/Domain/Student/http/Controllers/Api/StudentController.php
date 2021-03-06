<?php
namespace Domain\Student\http\Controllers\Api;

use Illuminate\Http\Request;
use Domain\Student\Models\Student;
use Illuminate\Support\Facades\DB;
use Domain\Student\DTO\StudentData;
use App\Http\Controllers\Controller;
use Domain\Student\Actions\CreateStudentAction;
use Domain\Student\http\Requests\StudentRequest;
use Domain\Student\http\Resources\StudentResource;

class StudentController extends Controller
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
    public function store(StudentRequest $request, CreateStudentAction $action)
    {
        try {
            DB::beginTransaction();

            $data = StudentData::fromRequest($request);

            $newStudent = $action($data);

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
}
