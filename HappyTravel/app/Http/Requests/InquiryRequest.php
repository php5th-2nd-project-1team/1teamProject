<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InquiryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validatorList = [
            'inquiry_title' => ['required', 'string', 'max:50'],
            'inquiry_content' => ['required'],
            'inquiry_secret' => ['required', 'boolean'],
        ];

        return $validatorList;
    }

    public function failedValidation(Validator $validator) {
        $response = response()->json([
            'success' => false,
            'msg' => '문의게시글 유효성 체크 오류',
            'data' => $validator->errors()->all(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
