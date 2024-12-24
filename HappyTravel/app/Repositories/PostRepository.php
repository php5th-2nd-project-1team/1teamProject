
<?php

use App\Models\PostComments;
use Illuminate\Http\Request;

class PostRepository {
    public function getCommentPagination(Request $request) {
        return PostComments::with('user')->where('post_id', '=', $request->id)->orderBy('created_at', 'DESC')->paginate(5);
    }
}