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
                component: require('dashboard/Home.vue')
            },
            {
                path: 'users',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/user/User.vue')
                    },
                    {
                        path: 'create',
                        component: require('dashboard/user/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/user/Edit.vue')
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
                        component: require('dashboard/article/Article.vue')
                    },
                    {
                        path: 'create',
                        component: require('dashboard/article/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/article/Edit.vue')
                    }
                ]
            },
            {
                path: 'discussions',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/discussion/Discussion.vue')
                    },
                    {
                        path: 'create',
                        component: require('dashboard/discussion/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/discussion/Edit.vue')
                    }
                ]
            },
            {
                path: 'comments',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/comment/Comment.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/comment/Edit.vue')
                    }
                ]
            },
            {
                path: 'tags',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/tag/Tag.vue')
                    },
                    {
                        path: 'Create',
                        component: require('dashboard/tag/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/tag/Edit.vue')
                    }
                ]
            },
            {
                path: 'files',
                component: require('dashboard/File.vue')
            },
            {
                path: 'categories',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/category/Category.vue')
                    },
                    {
                        path: 'create',
                        component: require('dashboard/category/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/category/Edit.vue')
                    }
                ]
            },
            {
                path: 'links',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('dashboard/link/Link.vue')
                    },
                    {
                        path: 'create',
                        component: require('dashboard/link/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('dashboard/link/Edit.vue')
                    }
                ]
            },
            {
                path: 'visitors',
                component: require('dashboard/Visitor.vue')
            },
            {
                path: 'system',
                component: require('dashboard/System.vue')
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