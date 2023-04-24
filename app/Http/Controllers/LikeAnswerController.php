<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $userId = Auth::id();

        // Kiểm tra liệu người dùng đã like chưa
        $existingLike = $answer->likes()->where('user_id', $userId)->first();

        // Nếu đã like
        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['unliked' => 'unliked']);

        // Nếu chưa đã like
        } else {
            $like = new Like();
            $like->user_id = $userId;
            $like->likeable()->associate($answer);
            $like->save();
            return response()->json(['liked' => 'liked']);
        }
    }
}
