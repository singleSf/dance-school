'use strict';

export default [
    {
        name     : 'home',
        path     : '/',
        meta     : {
            title: 'Школа танцев',
        },
        component: () => import('@component/home/index'),
    },
];