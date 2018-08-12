import DefaultComponent from './defaultComponent.vue';
const RequirementIndex = ()=> import(/* webpackChunkName: "requirement" */'../components/requirement/index.vue');
const RequirementAdd = ()=> import(/* webpackChunkName: "requirement" */'../components/requirement/add.vue');
const RequirementEdit = ()=> import(/* webpackChunkName: "requirement" */'../components/requirement/edit.vue');

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