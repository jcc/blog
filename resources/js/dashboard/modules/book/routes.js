export default [{
  path: 'book',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.book',
    component: () => import('./Book')
  }, {
    path: 'create',
    name: 'dashboard.book.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.book.edit',
    component: () => import('./Edit')
  }]
}]
