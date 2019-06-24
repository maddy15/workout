<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProgramResource;
use App\Program;
use Carbon\Carbon;
use App\History;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
       $programNotDone = $this->redirectToProgramIfThereAreExercisesUnfinished($request)->toArray();

       $programs = Program::all();
       
       if($programNotDone)
       {
            return  $this->redirectToUndoneExercise($programNotDone[0]['id']);
       }

       return view('program.index',compact('programs'));
    }

    public function show(Program $program,Request $request)
    {
        $programNotDone = $this->redirectToProgramIfThereAreExercisesUnfinished($request)->toArray();

        if($programNotDone)
        {
            if($program->id != $programNotDone[0]['id'])
            {
               return  $this->redirectToUndoneExercise($programNotDone[0]['id']);
            }
        }

        $exercises = $request->user()->exercises;

        $exerciseIds = $program->exercises->pluck('id')->toArray();

        $request->user()->exercises()->syncWithoutDetaching($exerciseIds);
        
        $request->user()->programs()->syncWithoutDetaching($program->id);

        $history = $program->histories()->ownedByUser()->latestFirst('desc')->first();
        
        $date = $history ? (new Carbon($history->created_at))->toDateString() : null;

        if($this->countExerciseFinishedForTheDay($request,$program->id) == $program->countExercise() 
        && ($date !== Carbon::now()->toDateString()))
        {
            $history = New History;

            $history->create([
                'user_id' => $request->user()->id,
                'program_id' => $program->id
            ]);
        }

        return view('program.show',compact('program'));
    }

    public function update(Request $request,Program $program)
    {
        $currentExercise = $request->user()->exercises->where('id',$request->exercise_id)->first();

        $request->user()->exercises()->updateExistingPivot($currentExercise->id,[
                'workout_date' => Carbon::now()
        ]);

        //update program progress
        
        $currentProgram = $program->users->where('id',$request->user()->id)->first();
        return $program->users()->updateExistingPivot(auth()->user()->id,[
            'progress' => $currentProgram->pivot->progress + 10  
        ]);
    }

    protected function countExerciseFinishedForTheDay(Request $request,$programId = null)
    {
        $id = $programId ? $programId : $request->id;

        $exercises = $request->user()->exercises->where('program_id',$id);

        return $exercises->filter(function($exercise){
        if($exercise->pivot->workout_date)
        {
            $date = new Carbon($exercise->pivot->workout_date);
            return $date->dayOfWeek == Carbon::now()->dayOfWeek;
        }
            return false;
        })->count();
    }

    protected function redirectToProgramIfThereAreExercisesUnfinished(Request $request)
    {
        $programs = Program::all();
        
        return $programs->filter(function($program) use ($request){

            $count = $this->countExerciseFinishedForTheDay($request,$program->id);
            
            if($count != 0 && $program->exercises->count() != $count)
            {
                return true;
            }
        });
    }

    protected function redirectToUndoneExercise($id)
    {
        return redirect()
            ->route('program.show',$id)
            ->withErrors('You must finish every exercise in this program');
    }
}