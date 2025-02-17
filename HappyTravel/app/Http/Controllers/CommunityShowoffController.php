<?php

namespace App\Http\Controllers;

use App\Models\CommunityBoard;
use Illuminate\Http\Request;

class CommunityShowoffController extends Controller
{
    public function index() {
        $communityShowoff = CommunityBoard::with(['communityPhotos', 'users'])->where('community_type' ,'=', '1')->paginate(4);

        $responseData = [
            'success' => true
            ,'msg' => '자랑게시판 리스트 획득 성공'
            ,'communityShowoff'=> $communityShowoff->toArray()
        ];

       return response()->json($responseData ,200);
    }
}
