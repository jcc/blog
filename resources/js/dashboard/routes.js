import { routes as article } from './modules/article/index'
import { routes as category } from './modules/category/index'
import { routes as comment } from './modules/comment/index'
import { routes as discussion } from './modules/discussion/index'
import { routes as file } from './modules/file/index'
import { routes as home } from './modules/home/index'
import { routes as link } from './modules/link/index'
import { routes as system } from './modules/system/index'
import { routes as tag } from './modules/tag/index'
import { routes as user } from './modules/user/index'
import { routes as visitor } from './modules/visitor/index'
import { routes as role } from './modules/role/index'

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
    ...role,
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
