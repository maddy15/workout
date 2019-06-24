@extends('layouts.app')

@section('styles')
<style>
.card
{
    opacity: 0;
    transform: translateY(-50px);
    /* transform-origin: 0; */
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h1>Program</h1>
        @foreach($programs as $program)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('program.show',$program->id)}}">{{ $program->name }}</a>
                        </h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
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
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(() => {
           var tl = TweenLite;
           var tll = new TimelineLite.TimelineLite();

            var card = tll.staggerTo('.card',.5,{
                transform : 'translateY(0)',
                opacity: 1
            },0.2)
        });
    </script>
@endsection
