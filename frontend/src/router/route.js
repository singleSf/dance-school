'use strict';

export default [
    {
        name     : 'home',
        path     : '/',
        meta     : {
            title: 'Школа танцев',
        },
        component: () => import('@component/home/index'),
        children : [
            {
                name     : 'auth',
                path     : 'auth',
                meta     : {
                    title: 'Авторизация',
                },
                component: () => import('@component/home/auth/index'),
            },
            {
                name     : 'office',
                path     : 'office',
                meta     : {
                    title: 'Школа танцев',
                },
                component: () => import('@component/home/office/index'),
                children : [
                    {
                        path     : 'school',
                        name     : 'school',
                        meta     : {
                            title: 'Школы',
                        },
                        component: () => import('@component/home/office/school/index'),
                    },
                    {
                        path     : 'hall',
                        name     : 'hall',
                        meta     : {
                            title: 'Залы',
                        },
                        component: () => import('@component/home/office/hall/index'),
                    },
                    {
                        path     : 'direction',
                        name     : 'direction',
                        meta     : {
                            title: 'Направления',
                        },
                        component: () => import('@component/home/office/direction/index'),
                    },
                    {
                        path     : 'subscription',
                        name     : 'subscription',
                        meta     : {
                            title: 'Уровни и цены',
                        },
                        component: () => import('@component/home/office/subscription/index'),
                    },
                ],
            },
        ],
    },
    {
        path     : '/:pathMatch(.*)',
        name     : 'notFound',
        meta     : {
            title: 'Страница не найдена!',
        },
        component: () => import('@component/home/index'),
    },
];