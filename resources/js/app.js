/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import  Sample  from './plugins/sample';

Vue.component('progress-level', require('./components/ProgressLevel.vue').default);
Vue.component('exercise', require('./components/Exercise.vue').default);
Vue.component('exercise-modal', require('./components/ExerciseModal.vue').default);
Vue.component('text-to-voice', require('./components/TextToVoice.vue').default);
Vue.component('exercise-calendar', require('./components/ExerciseCalendar.vue').default);
Vue.component('circle-progress', require('./components/CircleProgress.vue').default);


Vue.use(Sample.Sample);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
