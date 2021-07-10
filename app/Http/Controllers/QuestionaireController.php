<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Questionaire;
use App\Models\QuestionaireQuestion;
use App\Models\StudentAnswers;


class QuestionaireController extends Controller
{

    public function __construct(){
        $this->middleware('auth:sanctum');
    }


    public function index(){
        if(auth()->user()->role === "khateeb"){

            $questionaires = Questionaire::with(['course', 'questionaire_questions'])->get();
            return response()->json(['questionaires' => $questionaires], 200);
        }else if(auth()->user()->role === "student"){

        $userCourses = auth()->user()->courses->pluck('id');
        $questionaires = Questionaire::whereIn('course_id', $userCourses)->where('religion', auth()->user()->religion)->with('course', 'questionaire_questions')->get();
        
        $taken = auth()->user()->questionaires;
        $takenIds = auth()->user()->questionaires->pluck('id');
        $pending = $questionaires->whereNotIn('id', $takenIds);

        $newPending = [];

        foreach($pending as $p){
            $newPending[] =$p;
        }


        return response()->json([
            'questionaires' => $questionaires, 
            'taken' => $taken, 
            'pending' => $newPending
        ],200);
    }

        
    }

    public function getQuestions(Course $course, Questionaire $questionaire){
        $questions = QuestionaireQuestion::where('course_id', $course->id)->where('questionaire_id', $questionaire->id)->get();

        return response()->json(['questions' => $questions], 200);
    }


    public function store(Request $request, Course $course){
       
        if(auth()->user()->role == "khateeb"){
            $data = $request->validate([
                'title' => 'required|string',
                'religion' => 'required|string'
            ]);
    
            $data['course_id'] = $course->id;

            // return $data;
    
            if($questionaire = Questionaire::create($data)){
                return response()->json(['questionaire' => $questionaire], 200);
            }else{
                return response()->json(['err' => 'Something went wrong please try again later'], 403);
            }
        }else{
            return response()->json(['err' => 'Something went wrong please try again later'], 403);
        }

        

    }

    public function update(Request $request, Questionaire $questionaire){
       
        $data = $request->validate([
            'title' => 'required|string'
        ]);


        if($questionaire->update($data)){
            return response()->json(['success' => "Questionaire Updated successfully"], 200);
        }else{
            return response()->json(['err' => 'Something went wrong please try again later'], 403);
        }

    }

    public function destroy(Questionaire $questionaire){
     
        if(auth()->user()->role == "khateeb"){
            if($questionaire->delete()){
                return response()->json(['success' => "Questionaire Deleted successfully"], 200);
            }else{
                return response()->json(['err' => 'Something went wrong please try again later'], 403);
            }
    
        }else{
            return response()->json(['err' => 'Something went wrong please try again later'], 403);
        }

       
    }

    public function addQuestions(Request $request, Course $course, Questionaire $questionaire){

        if(auth()->user()->role == "khateeb"){
            $data = $request->validate([
                'data.*.question' => 'required',
                'data.*.course_id' => 'required',
                'data.*.questionaire_id' => 'required',
                'data.*.correct_answer' => 'required|string',
                'data.*.incorrect_answer1' => 'required|string',
                'data.*.incorrect_answer2' => 'required|string',
                'data.*.incorrect_answer3' => 'required|string',
            ]);
            
            foreach($data['data'] as $question){
                QuestionaireQuestion::create($question);
            }

            return response()->json(['success' => 'success'], 200);
        }else{
            return response()->json(['err' => 'Something went wrong please try again'], 403);
        }
        
    }

   public function deleteQuestion(QuestionaireQuestion $question){
       if(auth()->user()->role == "khateeb"){
        if($question->delete()){
            return response()->json(['success'=> 'success'], 200);
        }
       }else{
        return response()->json(['err'=> 'Something went wrong please try again'], 403);
       }
    
   }


   public function questionaireQuestions(Questionaire $questionaire){
       $questions = $questionaire->questionaire_questions->map(function($question){
           $answers = [ $question->correct_answer, $question->incorrect_answer1, $question->incorrect_answer2,$question->incorrect_answer3,];
            $id = $question->id;
            $question = $question->question;

           return [
               'id' => $id,
               'question' => $question, 
               'answers'  => collect($answers)->shuffle()
            ];
       });

       return response()->json(['questions'=> $questions], 200);
   }

   public function submit_answers(Request $request){

    // return $request->all();
    $data = $request->validate([
        'data.*.questionaire_question_id' => 'required',
        'data.*.questionaire_id' => 'required',
        'data.*.answer' => 'required|string',
    ]);
    
    // return $data['data'][0]['questionaire_id'];
    auth()->user()->questionaires()->attach($data['data'][0]['questionaire_id']);

    foreach($data['data'] as $record){
        $record['user_id'] = auth()->user()->id;
        StudentAnswers::create($record);

    }

        
        return response()->json(['success'=> 'success'], 200);
   
   }

   public function showResult(Questionaire $questionaire){
       
    // $res = StudentAnswers::where('user_id', auth()->user()->id)->where('questionaire_id', $questionaire->id)->with('question')->get();
    $res = StudentAnswers::where('user_id', auth()->user()->id)->where('questionaire_id', $questionaire->id)->with(['questionaire_question', 'questionaire'])->get();
    return response()->json(['res'=> $res], 200);
   }
}
