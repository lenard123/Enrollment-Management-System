import DefaultComponent from './defaultComponent.vue';
import Section from '../components/section/section.vue';
import SectionAdd from '../components/section/add.vue';
import SectionEdit from '../components/section/edit.vue';

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
		}

	]
}