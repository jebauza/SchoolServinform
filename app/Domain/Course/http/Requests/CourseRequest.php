<?php
namespace Domain\Course\http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $course_id = $this->route('id') ?? null;
        return [
            'name' => 'required|string|max:100',
            'students' => 'bail|array',
            'students.*' => 'integer|exists:students,id'
        ];
    }
}
