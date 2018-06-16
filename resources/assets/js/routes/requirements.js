import DefaultComponent from './defaultComponent.vue';
import RequirementIndex from '../components/requirement/index.vue';
import RequirementAdd from '../components/requirement/add.vue';
import RequirementEdit from '../components/requirement/edit.vue';

export default{
	path: 'requirement',
	component: DefaultComponent,
	children: [

		{
			path: '',
			component: RequirementIndex,
			name: 'Manage Requirement'
		},

		{
			path: 'add',
			component: RequirementAdd,
			name: 'Add Requirement'
		},

		{
			path: 'edit/:id',
			component: RequirementEdit,
			name: 'Edit Requirement'
		}
	]
}