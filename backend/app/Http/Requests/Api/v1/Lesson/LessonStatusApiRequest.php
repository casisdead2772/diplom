<?php


namespace App\Http\Requests\Api\v1\Lesson;


use App\Entities\User;
use App\Rules\NotIsCurrentUserRule;
use App\Rules\NotIsTeacherRule;
use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonStatusApiRequest extends FormRequest
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
            'status' => 'required', Rule::exists(User::class, 'id')
        ];
    }

}
