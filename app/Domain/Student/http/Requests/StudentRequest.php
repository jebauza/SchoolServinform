<?php
namespace Domain\Student\http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $student_id = $this->route('id') ?? null;
        return [
            'name' => 'required|string|max:100',
            'surnames' => 'required|string|max:255',
            'courses' => 'bail|array',
            'courses.*' => 'integer|exists:courses,id'
        ];
    }
}
