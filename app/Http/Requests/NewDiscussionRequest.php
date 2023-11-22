<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class NewDiscussionRequest extends FormRequest
{

    /* get current user for new discussion */

    public function getMemberForm()
    {
        return Auth::id();
    }

    /* generate slug for new discussions */

    public function generateDiscussionSlug($input)
    {
        return Str::slug($input, '-').'-'.random_int(100000, 999999);
    }

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
            'title' => 'required',
            'slug' => 'required|unique:discussions,slug',
            'category' => 'required',
            'content' => 'required|min:10',
            'member' => 'required'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'member' => $this->getMemberForm(),
            'slug' => $this->generateDiscussionSlug($this->title)
        ]);
    }
}
