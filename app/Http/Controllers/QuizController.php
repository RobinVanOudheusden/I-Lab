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
        $request->validate([
            'name' => 'required|string|unique:quiz,name',
        ]);

        $quiz = Quiz::create([
            'name' => $request->name,
            'questions' => [], // Initialize with empty questions
        ]);
        return redirect()->route('quiz.edit', $quiz->id);
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        // Assuming 'questions' is a JSON field in the 'quiz' table
        $questions = $quiz->questions ?? [];

        return view('quiz.edit', compact('quiz', 'questions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:quiz,name,' . $id,
            'questions' => 'required|json',
        ]);

        $quiz = Quiz::find($id);
        if (!$quiz) {
            return redirect()->route('quiz.index')->with('error', 'Quiz not found');
        }
        else if (Quiz::where('name', $request->name)->where('id', '!=', $id)->exists()) {   
            return redirect()->route('quiz.edit', $id)->with('error', 'Quiz name already exists');
        }
        else {
            $quiz->name = $request->name;
            // Decode the JSON questions to ensure they're stored correctly
            $quiz->questions = json_decode($request->questions, true);
            $quiz->save();
            return redirect()->route('quiz.edit', $id)->with('success', 'Quiz updated successfully.');
        }
    }

    public function destroy($id)
    {
        // Implement destroy logic if necessary
        $quiz = Quiz::find($id);
        if ($quiz) {
            $quiz->delete();
            return redirect()->route('quiz.index')->with('success', 'Quiz deleted successfully.');
        }
        return redirect()->route('quiz.index')->with('error', 'Quiz not found.');
    }

    // Remove getAllQuestions method if it's no longer needed
}
