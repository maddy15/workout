import Vue from 'vue';

const Sample = {
    install(Vue){
        Vue.prototype.$sample = {
            show(sample)
            {
                console.log(sample);
            }
        }
    }
}


export default {
    Sample
}