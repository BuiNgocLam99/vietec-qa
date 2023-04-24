<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        dd($question);
        // return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        if($request->parent_id){
            $request->validate([
                'parent_id' => 'numeric',
            ]);
        }

        $request->validate([
            'body' => 'required',
            'user_id' => 'numeric',
        ]);

        $question->answers()->create([
            'parent_id' => $request->parent_id ? $request->parent_id : null,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        $likedAnswers = auth()->user()->likes()->where('likeable_type', 'App\Models\Answer')->pluck('likeable_id')->toArray();

        $returnHTML = view('answers.answers_question')->with(['question' => $question, 'likedAnswers' => $likedAnswers])->render();
        return response()->json([
            'html' => $returnHTML
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        // dd($answer);
        // Answer::destroy($request->answer_id);
        $answer->delete();
        $likedAnswers = auth()->user()->likes()->where('likeable_type', 'App\Models\Answer')->pluck('likeable_id')->toArray();
        $returnHTML = view('answers.answers_question')->with(['question' => $question, 'likedAnswers' => $likedAnswers])->render();
        return response()->json([
            'html' => $returnHTML
        ]);

        // $this->authorize('delete', $answer);

        // $answer->delete();

        // if (request()->expectsJson()) {
        //     return response()->json([
        //         'message' => "Your answer has been removed"
        //     ]);
        // }

        // return back()->with('success', "Your answer has been removed");
    }
}
