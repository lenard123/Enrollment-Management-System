require('./bootstrap');

import VueRouter from 'vue-router';
import routes from './routes.js';
import Util from './util.js';

Vue.use(VueRouter);
Vue.mixin(Util);


//Custom Components

let cp = './components/mycomponents/'; //Component Path

Vue.component('panelDefault', require(`${cp}panel_default.vue`));
Vue.component('formGroup', require(`${cp}form_group.vue`));

Vue.component('modal', require(`${cp}modal/modal.vue`));
Vue.component('modalHeader', require(`${cp}modal/header.vue`));
Vue.component('modalBody', require(`${cp}modal/body.vue`));
Vue.component('modalFooter', require(`${cp}modal/footer.vue`));

const router = new VueRouter({
	linkActiveClass: 'l-selected',
	routes
});


const app = new Vue({
	created: function () {
		this.util.setAuthorization();
	},

    router,
    el: '#app'
});
