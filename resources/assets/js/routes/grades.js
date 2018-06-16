import DefaultComponent from './defaultComponent.vue';
import GradeIndex from '../components/grade/index.vue';
import GradeAdd from '../components/grade/add.vue';
import GradeEdit from '../components/grade/edit.vue';

export default			{
	path: 'grade',
	component: DefaultComponent,
	children: [

		{
			path: '',
			component: GradeIndex,
			name: 'Manage Grade'
		},

		{
			path: 'add',
			component: GradeAdd,
			name: 'Add Grade',
			beforeEnter: (to, from, next) => {
				if (from.name != "Manage Grade")
					next({name: "Manage Grade"});
				else next();
			}
		},

		{
			path: 'edit/:id',
			component: GradeEdit,
			name: 'Edit Grade',
			beforeEnter: (to, from, next) => {
				if (from.name != "Manage Grade")
					next({name: "Manage Grade"});
				else next();
			}
		}

	]
}