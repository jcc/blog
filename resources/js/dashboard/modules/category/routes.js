export default [{
  path: 'categories',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.category',
    component: () => import('./Category')
  }, {
    path: 'create',
    name: 'dashboard.category.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.category.edit',
    component: () => import('./Edit')
  }]
}]
