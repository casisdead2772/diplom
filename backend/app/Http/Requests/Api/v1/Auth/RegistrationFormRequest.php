<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Dto\v1\Api\User\UserStoreDto;
use App\Traits\ApiFailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegistrationFormRequest
 * @package App\Http\Requests
 * @author Kostykevich Artyom <kstartfd@gmail.com>
 */
class RegistrationFormRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\Entities\User'],
            'password' => 'required|min:3|max:25',
        ];
    }

    /**
     * @return UserStoreDto
     */
    public function getDto(): UserStoreDto
    {
        return new UserStoreDto(
            $this->get('email'),
            Hash::make($this->get('password')),
        );
    }
}
