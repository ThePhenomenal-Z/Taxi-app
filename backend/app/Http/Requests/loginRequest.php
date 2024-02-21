<?php

namespace App\Http\Requests;

use App\Models\User;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class loginRequest extends FormRequest
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
            'phoneNumber'=>'required|Numeric',
            'isDriver'=>'required|boolean'
        ];
    }
    public function saveOrUpdatePhoneNumber($phoneNumber)
    {
        // Create an instance of PhoneNumberUtil
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            // Parse the phone number
            $parsedNumber = $phoneUtil->parse($phoneNumber, '00963');

            // Format the phone number with the static country code
            $formattedNumber = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);

            return $formattedNumber;
        } catch (\libphonenumber\NumberParseException $e) {
            // Handle the exception if the phone number is invalid
            return $phoneNumber;
        }
    }
        // validation error handeling
        protected function failedValidation(Validator $validator)
        {
            throw new HttpResponseException(response()->json([
                'errors' => $validator->errors()
            ], 422));
        }
}
