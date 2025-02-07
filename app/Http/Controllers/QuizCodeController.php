<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizCodeController extends Controller
{
    public function checkCode(Request $request)
    {
        // this gives me a error even if the code is valid
        
        if (!preg_match('/^\d{6}$/', $request->quiz_id)) {
            return view('quiz.join', ['error' => 'De code is niet geldig.']);
        }

        else {
            return view('quiz.join', ['success' => 'De code is geldig.']);
            // Maak hier de logica om de speler te laten joinen
        }
    }
}
