<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ exercise.name }}
                </h5>
                <hr>
                <p class="card-text">{{ exercise.description }}</p>
                <exercise-modal :workout="exercise"></exercise-modal>
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        props:{
            exercise : null
        }
    }
</script>

<style lang="scss" scoped>

</style>