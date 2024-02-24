<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(User $user): bool
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
            "year"=>["sometimes","required","integer"],
            "type"=>["sometimes","required"],
            "model"=>["sometimes","required"],
            "color"=>["sometimes","required"],
            "license_plate"=>["sometimes","required"],
            "name"=>["sometimes","required"],
            "phoneNumber"=>["sometimes","required","unique:users"],
        ];
    }
     // validation error handeling
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json([
             'errors' => $validator->errors(),
             'message' => 'The given data is invalid.',
         ], 422));
     }
}
