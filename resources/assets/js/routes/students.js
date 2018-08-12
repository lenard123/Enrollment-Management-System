import DefaultComponent from './defaultComponent.vue';
const StudentsAll = ()=> import(/* webpackChunkName: "student" */'../components/student/all.vue');
const StudentAdd = ()=> import(/* webpackChunkName: "student" */'../components/student/add.vue');
const StudentEdit = ()=> import(/* webpackChunkName: "student" */'../components/student/edit.vue');
const StudentEnroll = ()=> import(/* webpackChunkName: "student" */'../components/student/enroll.vue');

export default{
	path: 'student',
	component: DefaultComponent,
	children: [

		{
			path: '/student/:type',
			component: StudentsAll,
			name: 'All Student'
		},

		{
			path: 'add',
			component: StudentAdd,
			name: 'Add Student',
			beforeEnter: (to, from, next) => {
				if (from.name != "All Student")
					next({name: 'All Student'});
				else next();
			}
		},

		{
			path: 'edit/:id',
			component: StudentEdit,
			name: 'Edit Student',
			beforeEnter: (to, from, next) => {
				if (from.name != "All Student" && from.name != "Enroll Student" && from.name != "Section Student")
					next({name: 'All Student', params: {type:'all'}});
				else next();
			}
		},

		{
			path: 'enroll/:id',
			component: StudentEnroll,
			name: 'Enroll Student',
			beforeEnter: (to, from, next) => {
				if (from.name != 'Edit Student')
					next({name: 'All Student'});
				else next();
			}
		}

	]
}