<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')
                           ->withCount('likes', 'answers')
                           ->latest()
                           ->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $question = $request->user()->questions()->create($request->only('title', 'body'));

        $url = route('questions.show', $question->slug);
        return response()->json(['url' => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $question = Question::with('user', 'answers.user.likes', 'answers.replies.user.likes', 'user.likes')
                ->whereSlug($request->slug)
                ->firstOrFail();
        $question->increment('views');

        $likedQuestions = $likedAnswers = [];
        if (auth()->check()) {
            $likedQuestions = auth()->user()->likes()->where('likeable_type', 'App\Models\Question')->pluck('likeable_id')->toArray();
            $likedAnswers = auth()->user()->likes()->where('likeable_type', 'App\Models\Answer')->pluck('likeable_id')->toArray();
        }

        // Cách này ít hơn 1 câu query 
        // if (auth()->check()) {
        //     foreach ($question->likes as $like) {
        //         if ($like->likeable_type === 'App\Models\Question') {
        //             $likedQuestions[] = $like->likeable_id;
        //         } elseif ($like->likeable_type === 'App\Models\Answer') {
        //             $likedAnswers[] = $like->likeable_id;
        //         }
        //     }
        // }
        // dd($likedAnswers);        
        return view('questions.show', compact('question', 'likedQuestions', 'likedAnswers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->authorize("update", $question);
        return view("questions.edit", compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        dd($request->all(), $question);
        $question->update($request->only('body'));

        if ($request->expectsJson())
        {
            return response()->json([
                'message' => "Your question has been updated.",
                'body_html' => $question->body_html
            ]);
        }

        return redirect('/questions')->with('success', "Your question has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        return $question->delete();
    }
}
