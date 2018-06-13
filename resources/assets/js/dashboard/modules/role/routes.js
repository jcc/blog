export default [{
  path: 'roles',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.role',
    component: () => import('./Role')
  }, {
    path: 'create',
    name: 'dashboard.role.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.role.edit',
    component: () => import('./Edit')
  }, {
    path: ':id/permissions',
    name: 'dashboard.role.permission',
    component: () => import('./Permission')
  }]
}]
