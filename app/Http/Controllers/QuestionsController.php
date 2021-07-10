<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Further;

class QuestionsController extends Controller
{

    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function index(){
        
        if(auth()->user()->role == "khateeb"){
            $questions = Question::with('furthers')->get();

        }else if(auth()->user()->role == 'student'){

            $questions = Question::with('furthers')->get();
        }

        return response()->json(['questions' => $questions], 200);
    }

    public function studentQuestions(){
        $questions = Question::where('user_id', auth()->user()->id)->with('furthers')->get();

        return response()->json(['questions' => $questions], 200);
    }

    public function store(Request $request){
        $data = $request->validate([
            'question' => 'required|string'
        ]);
        $data['user_id'] = auth()->user()->id;

        if($question = Question::create($data)){
            return response()->json(['question' => $question],200);
        }else{
            return response()->json(['err' => 'something went wrong please try again'], 403);
        }
    }

    public function answer(Request $request, Question $question){

        if(auth()->user()->role == "khateeb"){
            $data =  $request->validate([
                'answer' => 'required|string'
            ]);
    
            $data['answer_by'] = auth()->user()->name;
    
            if($question->update($data)){
                return response()->json(['success' => 'Answer Submitted'],200);
            }else{
                return response()->json(['err' => 'something went wrong please try again'], 403);
            }
        }else{
            return response()->json(['err' => 'something went wrong please try again'], 403);
        }

        
    }

    public function further(Request $request, Question $question){
        // return $request->all();
        $data = $request->validate([
            'further' => 'required|string'
        ]);


        if($question->furthers()->create(['further' => $data['further']])){
            return response()->json(['success' => 'success'], 200);
        }else{
            return response()->json(['err' => 'err'], 403);
        }


    }

    public function furtherAnswer(Request $request, Further $further){

        $data = $request->validate([
            'answer' => 'required|string'
        ]);

        if($further->answer()->create($data)){
            return response()->json(['success' => 'success'], 200);
        }else{
            return response()->json(['err' => 'Something went wrong please try again'], 403);
        }

    }
}
