<?php

namespace App\Http\Requests\Api\v1\Teacher;

use App\Entities\Country;
use App\Entities\Specialty;
use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherListRequest extends FormRequest
{
    use ApiFailedValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'country_id' => ['nullable', 'array'],
            'limit' => ['integer', 'nullable'],
            'page' => ['integer', 'nullable'],
            'sort' =>  ['string', 'nullable'],
            'subject_id' => ['required', 'integer', Rule::exists(Specialty::class, 'id')],
            'price_per_hour_from' => ['required', 'integer', 'min:1', 'lt:price_per_hour_to'],
            'price_per_hour_to' => ['required', 'integer','max:100', 'gt:price_per_hour_from']
        ];
    }
}