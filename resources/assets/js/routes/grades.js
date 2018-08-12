import DefaultComponent from './defaultComponent.vue'; 
const GradeIndex = ()=> import(/* webpackChunkName: "grade" */'../components/grade/index.vue');
const GradeAdd = ()=> import(/* webpackChunkName: "grade" */'../components/grade/add.vue');
const GradeEdit = ()=> import(/* webpackChunkName: "grade" */'../components/grade/edit.vue');

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