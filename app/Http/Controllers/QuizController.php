<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quiz.index', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $quiz = Quiz::create([
            'name' => $request->name,
        ]);
        return redirect()->route('quiz.edit', $quiz->id);
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        // Assuming 'questions' is a JSON field in the 'quizzes' table
        $questions = $quiz->questions ?? [];

        return view('quiz.edit', compact('quiz', 'questions'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return redirect()->route('quiz.index')->with('error', 'Quiz not found');
        }
        else if (Quiz::where('name', $request->name)->exists()) {   
            return redirect()->route('quiz.edit', $id)->with('error', 'Quiz name already exists');
        }
        else {
            $quiz->name = $request->name;
            $quiz->save();
            return redirect()->route('quiz.edit', $id);
        }
    }

    public function getAllQuestions($id)
    {
        $quiz = Quiz::find($id);
        $questions = $quiz->questions;
        return response()->json($questions);
    }
}
