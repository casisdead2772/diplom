<?php

namespace App\Http\Requests\Api\v1\User;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    use ApiFailedValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ];
    }
}
