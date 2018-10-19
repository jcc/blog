export default [{
  path: 'users',
  component: () => import ('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.user',
    component: () =>
      import ('./User')
  }, {
    path: 'create',
    name: 'dashboard.user.create',
    component: () =>
      import ('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.user.edit',
    component: () =>
      import ('./Edit')
  }]
}]
