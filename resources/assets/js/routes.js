import index from './components/index.vue';
import login from './components/login.vue';

import RouteRequirement from './routes/requirements.js';
import RouteGrade from './routes/grades.js';
import RouteSection from './routes/sections.js';
import RouteStudent from './routes/students.js';

const NotFoundPage = {
	template: '<div class="jumbotron"><h1>Page Not Found</h1></div>'
}

export default[
	{
		path: '/',
		component: index,
		children: [

			{
				path: '',
				component: NotFoundPage,
				name: 'Home'
			},

			RouteRequirement,
			RouteGrade,
			RouteSection,
			RouteStudent
		]
	},

	{
		path: '/login',
		component: login,
		name: 'Login'
	}
];