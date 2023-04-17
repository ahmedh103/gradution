<?php

namespace App\Http\Requests\CourseRequest;

use Illuminate\Foundation\Http\FormRequest;

class saveCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required',
            'description'=> 'required',
            'images'=>'required',
            'instructor_id'=>'required|exists:instructors,id'
        ];
    }
}
