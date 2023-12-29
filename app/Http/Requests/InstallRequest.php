<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class InstallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'username' => 'required|unique:users,username',
            'group' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'avatar' => 'required',

        ];
    }

    public function generateDefaultAvatar($input)
    {
        $avatarFileName = Str::slug($input, '-').'-default.png';
        return $avatarFileName;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'avatar' => $this->generateDefaultAvatar($this->username)
        ]);
    }
}