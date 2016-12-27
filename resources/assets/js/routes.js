import Dashboard from './views/Dashboard.vue'
import Parent from './views/Parent.vue'

export default [
    {
        path: '/dashboard',
        component: Dashboard,
        beforeEnter: requireAuth,
        children: [
            {
                path: '/',
                redirect: '/dashboard/home'
            },
            {
                path: 'home',
                component: require('./views/dashboard/Home.vue')
            },
            {
                path: 'users',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/user/User.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/user/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/user/Edit.vue')
                    }
                ]
            },
            {
                path: 'articles',
                component: Parent,
                children: [
                    {
                        path: '/',
                        name: 'articles',
                        component: require('./views/dashboard/article/Article.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/article/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/article/Edit.vue')
                    }
                ]
            },
            {
                path: 'discussions',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/discussion/Discussion.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/discussion/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/discussion/Edit.vue')
                    }
                ]
            },
            {
                path: 'comments',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/comment/Comment.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/comment/Edit.vue')
                    }
                ]
            },
            {
                path: 'tags',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/tag/Tag.vue')
                    },
                    {
                        path: 'Create',
                        component: require('./views/dashboard/tag/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/tag/Edit.vue')
                    }
                ]
            },
            {
                path: 'files',
                component: require('./views/dashboard/File.vue')
            },
            {
                path: 'categories',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/category/Category.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/category/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/category/Edit.vue')
                    }
                ]
            },
            {
                path: 'links',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/dashboard/link/Link.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/dashboard/link/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/dashboard/link/Edit.vue')
                    }
                ]
            },
            {
                path: 'visitors',
                component: require('./views/dashboard/Visitor.vue')
            },
            {
                path: 'system',
                component: require('./views/dashboard/System.vue')
            },
            {
                path: '*',
                redirect: '/dashboard'
            }
        ]
    }
]

function requireAuth (to, from, next) {
    if (window.User) {
        return next()
    } else {
        return next('/')
    }
}