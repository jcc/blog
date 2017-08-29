import Dashboard from 'views/Dashboard.vue'
import Parent from 'views/Parent.vue'

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
                component: () => import('dashboard/Home.vue'),
            },
            {
                path: 'users',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/user/User.vue')
                    },
                    {
                        path: 'create',
                        component: () => import('dashboard/user/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/user/Edit.vue')
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
                        component: () => import('dashboard/article/Article.vue')
                    },
                    {
                        path: 'create',
                        component: () => import('dashboard/article/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/article/Edit.vue')
                    }
                ]
            },
            {
                path: 'discussions',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/discussion/Discussion.vue')
                    },
                    {
                        path: 'create',
                        component: () => import('dashboard/discussion/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/discussion/Edit.vue')
                    }
                ]
            },
            {
                path: 'comments',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/comment/Comment.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/comment/Edit.vue')
                    }
                ]
            },
            {
                path: 'tags',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/tag/Tag.vue')
                    },
                    {
                        path: 'Create',
                        component: () => import('dashboard/tag/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/tag/Edit.vue')
                    }
                ]
            },
            {
                path: 'files',
                component: () => import('dashboard/File.vue')
            },
            {
                path: 'categories',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/category/Category.vue')
                    },
                    {
                        path: 'create',
                        component: () => import('dashboard/category/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/category/Edit.vue')
                    }
                ]
            },
            {
                path: 'links',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: () => import('dashboard/link/Link.vue')
                    },
                    {
                        path: 'create',
                        component: () => import('dashboard/link/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: () => import('dashboard/link/Edit.vue')
                    }
                ]
            },
            {
                path: 'visitors',
                component: () => import('dashboard/Visitor.vue')
            },
            {
                path: 'system',
                component: () => import('dashboard/System.vue')
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
