import DefaultComponent from './defaultComponent.vue';
import StudentsAll from '../components/student/all.vue';
import StudentAdd from '../components/student/add.vue';
import StudentEdit from '../components/student/edit.vue';
import StudentEnroll from '../components/student/enroll.vue';

export default{
	path: 'student',
	component: DefaultComponent,
	children: [

		{
			path: 'all',
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
				if (from.name != "All Student")
					next({name: 'All Student'});
				else next();
			}
		},

		{
			path: 'enroll/:id',
			component: StudentEnroll,
			name: 'Enroll Student',
			beforeEnter: (to, from, next) => {
				if (from.name != 'Edit Student')
					next({name: 'Edit Student', params:to.params});
				else next();
			}
		}

	]
}