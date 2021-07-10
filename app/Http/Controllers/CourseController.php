<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;
use \App\Models\Lesson;
use \App\Models\Explanation;
use \App\Models\Reply;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        if(auth()->user()->role == "khateeb"){
            $courses = Course::all();
            return response()->json(['courses' => $courses], 200);
        }else if(auth()->user()->role == 'student'){
            $registeredCourses = auth()->user()->courses;

            $ids = auth()->user()->courses->pluck('id');

            $unregistered = Course::whereNotIn('id', $ids)->get();

            // return $unregistered;
            

            return response()->json([
                'registered' => $registeredCourses, 
                'unregistered' => $unregistered, 
                'courses' => Course::all()
            ], 200);
        }
        
       
        
    }

    public function registerCourse(Request $request, Course $course){
        
        
        if(auth()->user()->role == "student"){
            $user = auth()->user();

        $user->courses()->attach($course->id);

        
        }else{
            return response()->json(['err' => 'Something went wrong please try again'], 200);
        }

        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(auth()->user()->role == "khateeb"){
            $data = $request->validate([
                'title' => 'required|string|unique:courses|min:2',
                'description' => 'required|string'
            ]);
    
            if($course = Course::create($data)){
                return response()->json(['course' => $course], 200);
            }else{
                return response()->json(['err' => "something went wrong please try again"], 403);
            }
        }else{
            return response()->json(['err' => "something went wrong please try again"], 403);
        }
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|unique:courses,'.$course->id,
            'description' => 'required|string'
        ]);

        if($course->update($data)){
            return response()->json(['success' => 'Course Updated Successfully'], 200);
        }else{
            return response()->json(['err' => "something went wrong please try again"], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if(auth()->user()->role == "khateeb"){
            if($course->delete()){
                return response()->json(['success' => 'Course Deleted Successfully'], 200);
            }else{
                return response()->json(['err' => "something went wrong please try again"], 403);
            }
        }else{
            return response()->json(['err' => "something went wrong please try again"], 403);
        }
        
    }

    public function addLesson(Request $request, Course $course){

        

        if(auth()->user()->role== "khateeb"){
            $data =  $request->validate([
                'content' => 'required|string',
                'content_for' => 'required|string',
            ]);
            $data['course_id']= $course->id;
            
            if($request->explanation !== null){
                $data['explanation'] = $request->validate(['explanation' => 'string']);
            }
            
    
            
            // return $data['explanation']['explanation'];
            if($lesson = Lesson::create($data)){
                if(strlen($data['explanation']['explanation']) > 0){
                    Explanation::create(['lesson_id' => $lesson->id, 'explanation' => $data['explanation']['explanation']]);
                }
                return response()->json(['success' => 'success'], 200); 
            }else{
                return response()->json(['err' => "something went wrong please try again"], 403);
            }
        }else{
            return response()->json(['err' => "something went wrong please try again"], 403);
        }
        
    }

    public function getLessons(Course $course){

        if(auth()->user()->role == "khateeb"){
            $explanation = "";
            if($course->lessons->where('content_for', 'muslim')->count()){

                $muslimLessons = json_decode($course->lessons->where('content_for', 'muslim')->first()->content);
                $explanation = $course->lessons->where('content_for', 'muslim')->first()->explanation;
                // return $explanation;
            }else{
                $muslimLessons = [];
            }
            $explanationForNonMuslim = "";
            if($course->lessons->where('content_for', 'non-muslim')->count()){
                $explanationForNonMuslim = $course->lessons->where('content_for', 'non-muslim')->first()->explanation;

                $nonmuslimLessons = json_decode($course->lessons->where('content_for', 'non-muslim')->first()->content);
            }else{
                $nonmuslimLessons=[];
            }
    
            return response()->json([
                'muslim_outline'=> $muslimLessons,
                'nonmuslim_outline' => $nonmuslimLessons,
                'title' => $course->title,
                'explanation' => $explanation,
                'explanationForNonMuslim' => $explanationForNonMuslim
                

            ], 200);
        }else{
            // return "we are here";
            if($course->lessons->where('content_for', auth()->user()->religion)->count()){
                $explanation = $course->lessons->where('content_for', auth()->user()->religion)->first()->explanation;
                $lessons = json_decode($course->lessons->where('content_for', auth()->user()->religion)->first()->content);
                // return $course->lessons;
            }else{
                $explanation = "";
                $lessons = [];
            }

            return response()->json(['lessons' => $lessons, 'explanation' => $explanation], 200);
        }
     

    }

    public function addReply(Request $request, Explanation $explanation){
        
        $data = $request->validate([
            'reply' => 'required|string'
        ]);

        $data['user_name'] = auth()->user()->name;
        if($explanation->replies()->create($data)){
            return response()->json(['success' =>  'success'], 200);
        }else{
            return response()->json(['err' =>  'Some thing went wrong please try again'], 403);
        }

    }

    public function answerReply(Request $request, Reply $reply){
        
        $data = $request->validate([
            'answer_reply' => 'required|string'
        ]);
        $data['answer_by'] = auth()->user()->name;

        if($reply->answer_reply()->create($data)){
            return response()->json(['success' =>  'success'], 200);
        }else{
            return response()->json(['err' =>  'Some thing went wrong please try again'], 403);
        }

    }
}
