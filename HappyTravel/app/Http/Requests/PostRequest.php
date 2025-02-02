<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
            'post_title' => ['required', 'string', 'max:50'],
            'category_local_num' => ['required'],
            'category_theme_num' => ['required'], 
            'post_local_name' => ['required', 'string', 'max:50'],
            'post_content' => ['required', 'string', 'max:200'],
            'post_detail_content' => ['required', 'string'],
            'post_img' => ['required', 'image'],
            'post_subimg1' => ['required','image'],
            'post_subimg2' => ['required','image'],
            'post_subimg3' => ['required','image'],
            'post_lat' => ['required'],
            'post_lon' => ['required'],
            'post_detail_num' => ['max:13'],
            'post_detail_addr' => ['required', 'string', 'max:500'],
            'post_detail_time' => ['required', 'string', 'max:50'],			
            'post_detail_site' => ['max:500'],
            'post_detail_price' => ['required', 'string', 'max:50'],
            'post_detail_parking' => ['required', 'string', 'max:1'],
            'animal_type_num' => ['required', 'array'],
            'facility_type_num' => ['array']
        ];

        if($this->routeIs('post.update')) {
            $validatorList['post_img'] = ['image'];
            $validatorList['post_subimg1'] = ['image'];
            $validatorList['post_subimg2'] = ['image'];
            $validatorList['post_subimg3'] = ['image'];
        }

        return $validatorList;
    }

    public function failedValidation(Validator $validator) {
        $response = response()->json([
            'success' => false,
            'msg' => '포스트 유효성 체크 오류',
            'data' => $validator->errors()->all(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
