
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

Vue.component('mosaic-component', require('./components/MosaicComponent.vue'));
Vue.component('select-component', require('./components/SelectgalleryComponent.vue'));
//Vue.component('collage-component', require('./components/CollageComponent.vue'));
Vue.component('image-component', require('./components/ImageComponent.vue'));
Vue.component('imageupload-component', require('./components/ImageuploadComponent.vue'));
Vue.component('imagelist-component', require('./components/ImagelistComponent.vue'));
Vue.component('imagelistpub-component', require('./components/ImagelistpubComponent.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('babylon-component', require('./components/BabylonComponent.vue'));

Vue.component('babylonmine-component', require('./components/BabylonmineComponent.vue'));

Vue.component('babylonsandbox-component', require('./components/BabylonsandboxComponent.vue'));

Vue.component('babylonphysics-component', require('./components/BabylonphysicsComponent.vue'));


Vue.component('mosaicupload-component', require('./components/MosaicuploadComponent.vue'));

/*********************/
var VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
Vue.use(VueCookie);




// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


 import {store } from './store/store';

const app = new Vue({
    el: '#app',
    store
});
