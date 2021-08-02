<?php


namespace App\Http\Requests\Api\v1\Quiz;


use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class QuizApiRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    /**
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
            'title' => 'required',
            'questions' => 'required'
        ];
    }
}
