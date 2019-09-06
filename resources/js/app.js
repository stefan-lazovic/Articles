////////////////////////////////////////////////////////////////////////////////
require('./bootstrap');
window.Vue = require('vue');



////////////////////////////////////////////////////////////////////////////////
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// configure your vue routes
const routes = [
  { path: '/', component: require('./components/Articles.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/create', component: require('./components/Create.vue').default }
]

// register your routes
const router = new VueRouter({
  mode: 'history',
  routes: routes
})



////////////////////////////////////////////////////////////////////////////////
import { Form, HasError, AlertError } from 'vform'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
// now we have access to Form in every place of our application
window.Form = Form;



////////////////////////////////////////////////////////////////////////////////
// Moment.js
import moment from 'moment';



////////////////////////////////////////////////////////////////////////////////
//  Froala WYSIWYG editor
require('froala-editor/js/froala_editor.pkgd.min.js')
import VueFroala from 'vue-froala-wysiwyg'
Vue.use(VueFroala)
require('froala-editor/js/plugins/image.min.js')


////////////////////////////////////////////////////////////////////////////////
// SweetAlert2
import Swal from 'sweetalert2'
window.Swal = Swal;



////////////////////////////////////////////////////////////////////////////////
// create a custom event ===> Fire.$emit('RefreshPage'), Fire.$on('RefreshPage', () => {})
window.Fire = new Vue();



////////////////////////////////////////////////////////////////////////////////
Vue.filter('slice', (value) => {
  if (value.length < 135) {
    return value;
  }
  return value.slice(0, 135) + '...';
});

Vue.filter('myDate', (value) => {
  return moment(value).format('MMMM Do YYYY') + ' ' + '(' + moment(value).fromNow() + ')';
});



////////////////////////////////////////////////////////////////////////////////
// Vue components
Vue.component('edit-component', require('./components/Edit.vue').default);
Vue.component('read-component', require('./components/Read.vue').default);
// laravel-vue-pagination
Vue.component('pagination', require('laravel-vue-pagination'));


////////////////////////////////////////////////////////////////////////////////
const app = new Vue({
    el: '#app',
    router
})
