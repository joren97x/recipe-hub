<?php

namespace App\Http\Requests;

use App\Rules\AtLeastOneElementInArray;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            //
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'ingredients' => ['required', new AtLeastOneElementInArray],
            'methods' => ['required', new AtLeastOneElementInArray]
        ];
    }
}
