<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginFormRequest
 * @package App\Http\Requests
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class LoginFormRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
