<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeQuestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = Auth::id();

        // Kiểm tra liệu người dùng đã like chưa
        $question = Question::findOrFail($request->question_id);
        $existingLike = $question->likes()->where('user_id', $userId)->first();

        // Nếu đã like
        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['unliked' => 'unliked']);

        // Nếu chưa đã like
        } else {
            $like = new Like();
            $like->user_id = $userId;
            $like->likeable()->associate($question);
            $like->save();
            return response()->json(['liked' => 'liked']);
        }
    }
}
