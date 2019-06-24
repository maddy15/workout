<template>
    <div>
        <!-- <h1>Circle Progress</h1> -->
        <vue-circle
        ref="myUniqueID"
        :progress="progress"
        :size="100"
        :reverse="false"
        line-cap="round"
        :fill="fill"
        empty-fill="rgba(0, 0, 0, .1)"
        :animation-start-value="0.0"
        :animation="animation"
        :start-angle="0"
        insert-mode="append"
        :thickness="10"
        :show-percent="false">
            {{ countdown }}
        </vue-circle>
    </div>
</template>

<script>
import VueCircle from 'vue2-circle-progress'
export default {
props:['countdown'],
data() {
    return {
        progress: 100,
        count : this.countdown,
        fill : { gradient: ["green"] },
        animation: { 
            duration: 500, 
            easing: 'circleProgressEasing' 
            }
    }
},
watch: {
    countdown(newValue, oldValue) {
        if(newValue == 3)
        {
            this.$refs.myUniqueID.updateFill('red');
        }
        this.$refs.myUniqueID.updateProgress(this.progress -= 1/ this.count * 100);
    },
},
components: {
    VueCircle
},
}
</script>

<style lang="scss" scoped>

</style>