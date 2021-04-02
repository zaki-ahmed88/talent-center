<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\ExamInterface;
use App\Http\Interfaces\QuestionInterface;
use App\Http\Traits\ApiDesignTrait;
//use App\Models\role;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Question;
use App\Models\Role;
use App\Models\StudentGroup;
use App\Models\SystemAnswer;
use App\Models\User;

use App\Http\Interfaces\StaffInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class QuestionRepository implements QuestionInterface{

    use ApiDesignTrait;


    private $question;
    private $exam;
    private $systemAnswer;
    private $examType;


    public function __construct(Question $question, Exam $exam, SystemAnswer $systemAnswer, ExamType $examType) {

        $this->question = $question;
        $this->exam = $exam;
        $this->systemAnswer = $systemAnswer;
        $this->examType = $examType;

    }




    public function allQuestions($request)
    {
        // TODO: Implement allQuestions() method.


        $validator = Validator::make($request->all(),[
            'exam_id' => 'required|exists:exams,id',
        ]);


        if($validator->fails()){
            return $this->apiResponse(422,'Error',$validator->errors());
        }



        $data = $this->question->where('exam_id', $request->exam_id)->get();

        return $this->ApiResponse('200', 'All Questions', null, $data);


    }





    public function addQuestion($request)
    {
        // TODO: Implement addQuestion() method.


        $validator = Validator::make($request->all(),[

            'title' => 'required',
            'exam_id' => 'required|exists:exam,id',

        ]);


        if($validator->fails()){
            return $this->apiResponse(422,'Errors',$validator->errors());
        }




        $question = $this->question->create([

            'title' => $request->title,
            'exam_id' => $request->exam_id,
        ]);




//        $questionType = $this->examType::where([['is_mark', 1], ['choice', 1]])->first();

        $examType = $this->exam::where(['id', $request->exam_id])->whereHas('examTypes', function ($q) {
            $q->where([['is_mark', 1], ['choice', 1]]);
        })->first();


        if($examType){
            //Add Choice Answers
        }



        $exam = $this->exam->where('id', $request->exam_id)->AutomatedMarked(1)->first();

        if($exam){

            $validator = Validator::make($request->all(),[
                'answer' => 'required',
            ]);

            if($validator->fails()){
                return $this->apiResponse(422,'Errors',$validator->errors());
            }

            $this->addQuestionAnswer($request->answer, $question->id);
            }

        return $this->ApiResponse(200, 'Added Successfully');


    }




    public function addQuestionAnswer($answer, $questionId){

        $this->systemAnswer->create([
            'question_id' => $questionId,
            'answer' => $answer,
        ]);
    }










    public function updateQuestion($request)
    {
        // TODO: Implement updateQuestion() method.



        $validator = Validator::make($request->all(),[

            'title' => 'required',
            'question_id' => 'required|exists:questions,id',

        ]);


        if($validator->fails()){
            return $this->apiResponse(422,'Errors',$validator->errors());
        }


        $question = $this->question->find($request->question_id)->first();


        $question->update([

            'title' => $request->title,
        ]);

        if($question->has('answer')){

            $this->systemAnswer->where('question_id', $question->id)->update([
               'answer' => $request->answer,
            ]);

        }

        return $this->apiResponse(200, 'Updated Successfully');


    }





    public function deleteQuestion($request)
    {
        // TODO: Implement deleteQuestion() method.

        $validator = Validator::make($request->all(),[
            'question_id' => 'required|exists:questions,id',
        ]);

        if($validator->fails()){
            return $this->apiResponse(422,'Error',$validator->errors());
        }

        $this->question::find($request->question_id)->delete();

        return $this->apiResponse(200, 'Deleted Successfully');
    }
}
