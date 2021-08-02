<?php

namespace App\Http\Requests\Api\v1\Teacher;

use App\Entities\Country;
use App\Entities\Language;
use App\Entities\LanguageGrade;
use App\Entities\Specialty;
use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherAboutStoreRequest extends FormRequest
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
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'first_name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
            'hourly_rate' => 'required|numeric',
            'language_id' => ['required', 'integer', Rule::exists(Language::class, 'id')],
            'language_grade_id' => ['required', 'integer', Rule::exists(LanguageGrade::class, 'id')],
            'subject_taught_id' => ['required', 'integer', Rule::exists(Specialty::class, 'id')],
        ];
    }
}