<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class MessageRequest extends FormRequest
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
        return [
            'from' => 'required',
            'to' => 'required',
            'subject' => 'required',
            'content' => 'required|min:10',
            'status' => 'required'
        ];
    }

    public function convertUsernameToID($input)
    {
        $user = User::where('username', $input)->get();
        foreach ($user as $u) {
            $userID = $u->id;
        }
        return $userID;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'to' => $this->convertUsernameToID($this->to)
        ]);
    }
}
