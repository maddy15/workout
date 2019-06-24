<template>
    <div>
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" :style="{ width: currentProgressLevel + '%'}"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="1000">
                {{ currentProgressLevel }}%
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            currentProgressLevel : null   
        },
        
    }
</script>

<style lang="scss" scoped>

</style>