import DefaultComponent from './defaultComponent.vue';
const Section = ()=> import(/* webpackChunkName: "section" */'../components/section/section.vue');
const SectionAdd = ()=> import(/* webpackChunkName: "section" */'../components/section/add.vue');
const SectionEdit = ()=> import(/* webpackChunkName: "section" */'../components/section/edit.vue');
const SectionStudent = ()=> import(/* webpackChunkName: "section" */'../components/section/students.vue');

export default{
	path: 'section',
	component: DefaultComponent,
	children: [

		{
			path: '',
			component: Section,
			name: 'Manage Section'
		},

		{
			path: 'add',
			component: SectionAdd,
			name: 'Add Section',
			beforeEnter: (to, from, next) => {
				if (from.name != 'Manage Section')
					next({name:'Manage Section'});
				else next();
			}
		},

		{
			path: 'edit/:id',
			component: SectionEdit,
			name: 'Edit Section',
			props: true,
			beforeEnter: (to, from, next) => {
				if (from.name != 'Manage Section')
					next({name:'Manage Section'});
				else next();
			}
		},

		{
			path: 'section/:id',
			component: SectionStudent,
			name: 'Section Student',
			props: true,
			beforeEnter: (to, from, next) => {
				if (from.name != 'Manage Section' && from.name != 'Edit Student')
					next({name: 'Manage Section'});
				else next();
			}
		}

	]
}