<?php

namespace App\Http\Requests\Api\v1\Lesson;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class LessonIndexApiRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable',
            'from_date' => 'nullable',
            'to_date' => 'nullable',
        ];
    }
}