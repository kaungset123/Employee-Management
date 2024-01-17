<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email',Rule::unique('users')->ignore($userId),],
            'phone' => 'required|numeric', 
            'date_of_birth' => 'required|date|before_or_equal:today', 
            'password' => 'string|nullable|min:6|confirmed:password_confirmation',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'ot_rate' => 'required|numeric|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'department_id' => 'nullable',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
