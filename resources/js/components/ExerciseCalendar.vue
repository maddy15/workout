<template>
    <div>
        <h1>Calendar</h1>
        <full-calendar :events="fcEvents"></full-calendar>
    </div>
</template>

<script>
import fullCalendar from 'vue-fullcalendar'

export default {
    components:{
        fullCalendar
    },
    data() {
        return {
            fcEvents: []
        }
    },
    methods: {
        getHistories() {
         axios.get('/history')
            .then(res => {
                res.data.data.forEach(event => {
                    this.fcEvents.push(event);
                })
            }); 
        }
    },
    created()
    {
        this.getHistories();
    }
}
</script>
