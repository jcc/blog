export default [{
  path: '/',
  redirect: { name: 'dashboard.home' },
}, {
  name: 'dashboard.home',
  path: 'home',
  component: () => import('./Home'),
}]
