export default [{
  path: 'tags',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.tag',
    component: () => import('./Tag')
  }, {
    path: 'create',
    name: 'dashboard.tag.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.tag.edit',
    component: () => import('./Edit')
  }]
}]
