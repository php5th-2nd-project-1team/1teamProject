<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
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
    public function rules() {
        $rules = [
            'post_comment' => ['required', 'between:1,200']
        ];

        // routeIs('store.postComment')에서 ()는 route에 name 을 적는것이다. 댓글작성 name 은 store.postComment
        if($this->routeIs('store.postComment')) {
            $rules['post_comment'] = ['required', 'between:1,200', 'regex:/^(?!\s*$).+$/'];
        }

        return $rules;
    }

    // 유효성 오류시 에러내기
    protected function failedValidation(Validator $validator) {
        $response = response()->json([
            'success' => true,
            'msg' => '댓글 유효성 체크 오류',
            'data' => $validator->errors(),
        ], 422);
        throw new HttpResponseException($response);
    }

    public function messages() {
        return [
            'post_comment.required' => '댓글을 작성하세요.',
            'post_comment.between' => '댓글은 1자 이상 200자 이하로 작성해주세요.',
            'post_comment.regex' => '댓글은 공백만 입력할수 없습니다.',
        ];
    }
}
