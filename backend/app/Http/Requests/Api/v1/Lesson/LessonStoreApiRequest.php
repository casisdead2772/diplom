<?php

namespace App\Http\Requests\Api\v1\Lesson;

use App\Entities\Lesson;
use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonStoreApiRequest extends FormRequest
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
            'lesson_id' => [
                'required',
                'integer',
                Rule::exists(Lesson::class, 'id')
            ],
        ];
    }
}