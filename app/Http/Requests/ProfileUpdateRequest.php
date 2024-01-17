<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email',Rule::unique('users')->ignore($userId),],
            'phone' => 'required|numeric', 
            'password' => 'string|nullable|min:6|confirmed:password_confirmation',
            'address' => 'required|string|max:255',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'           
        ];
    }
}
