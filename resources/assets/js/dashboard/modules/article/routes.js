export default [{
  path: 'articles',
  component: () => import('../../../App'),
  children: [{
    path: '/',
    name: 'dashboard.article',
    component: () => import('./Article')
  }, {
    path: 'create',
    name: 'dashboard.article.create',
    component: () => import('./Create')
  }, {
    path: ':id/edit',
    name: 'dashboard.article.edit',
    component: () => import('./Edit')
  }]
}]
