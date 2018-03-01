export default [{
  path: 'discussions',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.discussion',
    component: () => import('./Discussion')
  }, {
    path: 'create',
    name: 'dashboard.discussion.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.discussion.edit',
    component: () => import('./Edit')
  }]
}]
