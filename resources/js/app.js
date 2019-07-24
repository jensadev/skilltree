/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal';
Vue.use(VModal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


Vue.component('add-skill', require('./components/AddSkill.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('invite-skilltree-member', require('./components/InviteSkilltreeMember.vue').default);
Vue.component('save-load-skilltree-pos-con', require('./components/SaveLoadSkilltreePosCon.vue').default);
Vue.component('skill-card', require('./components/SkillCard.vue').default);
Vue.component('student-skill-card', require('./components/StudentSkillCard.vue').default);
Vue.component('edit-skill-modal', require('./components/EditSkillModal.vue').default);
Vue.component('new-skilltree-modal', require('./components/NewSkilltreeModal.vue').default);
Vue.component('manage-skilltree-modal', require('./components/ManageSkilltreeModal.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash', message);
};

const app = new Vue({
    el: '#app',
});

// Array.prototype.find = function(regex) {
//   var arr = this;
//   var matches = arr.filter( function(e) { return regex.test(e); } );
//   return matches.map(function(e) { return arr.indexOf(e); } );
// };

