'use strict';

export default [
    {
        name     : 'home',
        path     : '/',
        meta     : {
            title : 'Школа танцев',
            isAuth: false,
        },
        component: () => import('@component/home/index'),
        children : [
            {
                name     : 'auth',
                path     : 'auth',
                meta     : {
                    title : 'Авторизация',
                    isAuth: false,
                },
                component: () => import('@component/home/auth/index'),
            },
            {
                name     : 'logout',
                path     : 'logout',
                meta     : {
                    title : 'Выход',
                    isAuth: false,
                },
                component: () => import('@component/home/logout/index'),
            },
            {
                name     : 'office',
                path     : 'office',
                meta     : {
                    title : 'Личный кабинет',
                    isAuth: true,
                },
                component: () => import('@component/home/office/index'),
                children : [
                    {
                        path     : 'school',
                        name     : 'school',
                        meta     : {
                            title : 'Список школ',
                            isAuth: true,
                        },
                        component: () => import('@component/home/office/school/index'),
                    },
                    {
                        path     : 'school/:id(\\d+)',
                        name     : 'schoolCard',
                        meta     : {
                            title : 'Карточка школы',
                            isAuth: true,
                        },
                        props    : (_route) => ({
                            id: Number(_route.params.id),
                        }),
                        component: () => import('@component/home/office/school/card/index'),
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