<template>
    <div style="position:relative">
        <div class="box" v-if="checkIfExerciseIsDoneForTheDay">
            <p class="box-text"><small>This exercise is done</small></p>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#exampleModalCenter' + modalExercise.id">
            Workout
        </button>
        
        <br>

        <!-- Modal -->
        <div class="modal fade" :id="'exampleModalCenter' + modalExercise.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{ modalExercise.name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exit()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="countDown" class="text-center">
                    <p><small>Set {{ startingSet }} starts in...</small></p>
                    <circle-progress :countdown="countDown"></circle-progress>
                </div>
                
                <div v-else-if="workingOut">
                    <div class="float-right">{{startingSet}} / {{ exercise.set }} Set</div>
                    <div class="clearfix"></div>
                    <h1  class="text-center">{{ startRepetition }} / {{ exercise.repetition }}</h1>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" @click.prevent="exit()" v-if="!workingOut && show">Finished</button>
                <button type="button" class="btn btn-primary btn-block" @click.prevent="start(3)" v-if="!workingOut && !show">Let's Start</button>
                
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
    import VueCircle from 'vue2-circle-progress'
    export default {
        props:['exercise','users'],
        data() {
            return {
                modalExercise: this.exercise,
                countDown : 3,
                interValCountDown : null,
                interValRepetition : null,
                workingOut : false,
                startRepetition : 0,
                startingSet : 1,
                show: false,
                selectedVoice: 0,
                synth: window.speechSynthesis,
                voiceList: [],
                greetingSpeech: new window.SpeechSynthesisUtterance()
            }
        },
        computed: {
            getCurrentUser() {
                return this.users.filter(user =>{
                    return user.id == Laravel.user.id
                }) 
            },
            checkIfExerciseIsDoneForTheDay()
            {
                let exercisePivotDate = new Date(this.getCurrentUser[0].pivot.workout_date);
                let currentDate =  new Date();
                return exercisePivotDate.getDay() == currentDate.getDay();
            },
            isSetDone()
            {
                return this.startingSet < this.exercise.set
            },
        },
        methods:{
            start(countDown,tick = true)
            {
                this.progressing = 100;
                if(!this.workingOut)
                {
                    this.greet('The exercise will start in',2);
                }

                this.countDown = countDown;
                this.workingOut = true;
                var that = this;
                this.interValCountDown = setInterval(() => {
                    if(tick)
                    {
                        this.greet(this.countDown,2)
                        tick = false;
                    }
                    else
                    {
                        this.greet(--this.countDown,2);
                    }
                    if(this.countDown == 0)
                    {
                        this.stop();
                        this.startWorkOut();
                    }
                    
                },1400);
            },
            stop()
            {
                clearInterval(this.interValCountDown);
                clearInterval(this.interValRepetition);
            },
            startWorkOut()
            {
                this.interValRepetition = setInterval(() => {
                    
                    if(this.startRepetition < this.exercise.repetition)
                    {
                        this.greet(++this.startRepetition,2.5);
                    }
                    else
                    {
                        this.stop();
                        if(this.startingSet < this.exercise.set)
                        {
                            this.startingSet++;
                            this.startRepetition = 0;

                            this.greet('The next set will start in',2.5);
                            
                            this.start(this.getCurrentUser[0].rest_time);
                        }
                        else
                        {
                            this.updateProgress();
                            this.workingOut = false;
                            this.show = true;
                            this.greet(`${this.modalExercise.name} exercise finished`)
                            return;
                        }
                    }
                    
                },1300);
            },
            exit()
            {
                this.greet('Great Job!');
                this.workingOut = false;
                this.countDown = '';
                this.startRepetition = 0;
                this.startingSet = 1;
                this.stop();
                 location.replace("/program/" + this.exercise.program.id)
            },
            updateProgress()
            {
                axios.put('/program/' + this.exercise.program.id,{
                    'exercise_id' : this.exercise.id
                })
                .then( res => {
                    console.log(res);
                })
            },
            listenForSpeechEvents () {
                this.greetingSpeech.onstart = () => {
                    this.isLoading = true
                }

                this.greetingSpeech.onend = () => {
                    this.isLoading = false
                }
            },
            
            greet (value,rate = 1) {
            this.greetingSpeech.text = value;

            this.greetingSpeech.rate = rate;
            this.greetingSpeech.voice = this.voiceList[this.selectedVoice]
            
            
            this.synth.speak(this.greetingSpeech)
            }
        },
        components: {
            VueCircle
        },
        mounted () {
            this.voiceList = this.synth.getVoices()

            if (this.voiceList.length) {
            // this.isLoading = false
            }

            this.synth.onvoiceschanged = () => {
            this.voiceList = this.synth.getVoices()
            }

            this.listenForSpeechEvents()
            
            // this.updateProgress();
        },
        beforeMount()
        {
            // console.log(this.$sample.show('asd'));

        }
    }
</script>

<style lang="scss" scoped>
.box
{
    position:absolute;
    top : 0;
    right: 0;
    bottom: 0;
    left: 0;
    background:rgba(0,0,0,1);
    cursor:not-allowed;
}

.box .box-text
{
    color:#fff;
    position: absolute;
    top: 50%;
    left:50%;
    transform: translate(-50%,-50%);
}
</style>