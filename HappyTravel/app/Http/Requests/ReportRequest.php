<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validatorList = [
            'report_category' => ['required'],
            'report_board_id' => ['required'],
            'report_code' => ['required'],
            // 'report_status' => ['string'],     // 같이 삭제
            'report_text' => ['max:200'],
        ];
        // $this->merge([
        //     'report_status' => $this->input('report_status','01'),
        // ]);
        return $validatorList;
    }
    public function failedValidation(Validator $validator) {
        $response = response()->json([
            'success' => false
            ,'msg' => '신고 유효성검사 오류'
            ,'data' => $validator->errors()->all()
        ], 422);
        throw new HttpResponseException($response);
    }
}
