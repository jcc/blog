export default [{
  path: 'series',
  component: () => import('js/App.vue'),
  children: [{
    path: '/',
    name: 'dashboard.series',
    component: () => import('./Series')
  }, {
    path: 'create',
    name: 'dashboard.series.create',
    component: () => import('./Create')
  }, {
    path: ':edit/series/',
    name: 'dashboard.series.edit',
    component: () => import('./Edit')
  }]
}]
