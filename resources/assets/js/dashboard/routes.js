import { routes as article } from './modules/article'
import { routes as category } from './modules/category'
import { routes as comment } from './modules/comment'
import { routes as discussion } from './modules/discussion'
import { routes as file } from './modules/file'
import { routes as home } from './modules/home'
import { routes as link } from './modules/link'
import { routes as system } from './modules/system'
import { routes as tag } from './modules/tag'
import { routes as user } from './modules/user'
import { routes as visitor } from './modules/visitor'

export default [{
  path: '/dashboard',
  component: () => import ('./Main'),
  beforeEnter: requireAuth,
  children: [
    ...home,
    ...user,
    ...article,
    ...discussion,
    ...category,
    ...comment,
    ...tag,
    ...link,
    ...file,
    ...visitor,
    ...system,
  ],
}]

function requireAuth(to, from, next) {
  if (window.User) {
    return next()
  } else {
    return next('/')
  }
}
