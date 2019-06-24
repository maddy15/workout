@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('program.index') }}" class="btn btn-secondary text-white">Back</a>
    {{-- <progress-level current-progress-level={{ $program->userProgressLevel() }}></progress-level> --}}
    @if(session()->has('errors'))
    <div class="alert alert-danger mt-4">
        {{ session('errors') }}
    </div>
    @endif

    <div class="mt-4">
        <div class="float-left"><small>{{ $program->getCurrentLevel()['levelName'] }}</small></div>
        <div class="float-right"><small>{{ $program->getCurrentLevel()['nextLevelName'] }}</small></div>
    </div>
    <div class="clearfix"></div>
    <div class="progress">
        
        <div class="progress-bar bg-success" 
            role="progressbar" 
            style="width: {{ $program->getPercentageToNextLevel() }}%" 
            aria-valuenow="{{ $program->userProgressLevel() }}" 
            aria-valuemin="0" 
            aria-valuemax="{{ $program->getCurrentLevel()['nextExperience'] }}">
            @if($program->getCurrentLevel()['levelId'] == 3)
                {{ 'max' }}
            @else
            {{ $program->userProgressLevel() }} / {{ $program->getCurrentLevel()['nextExperience'] }}
            @endif
        </div>
    </div>

    <h1 class="mt-4">{{ $program->name }} Program for {{ $program->getCurrentLevel()['levelName'] }} level.</h1>
    <div class="row mt-4">
        @foreach($program->exercises as $exercise)
            <div class="col-md-4 mb-4">
                <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $exercise->name }}
                            </h5>
                            <hr>
                            <p class="card-text">{{ $exercise->description }}</p>
                            
                            <exercise-modal :exercise="{{ json_encode($exercise) }}" :users="{{ json_encode($exercise->users) }}"></exercise-modal>
                        </div>
                    </div>
            </div>
            
        @endforeach
    </div>
</div>
@endsection


