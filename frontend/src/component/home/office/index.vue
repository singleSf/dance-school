<template lang="pug">
div
    ul
        li
            router-link(:to="Router.routes.home.office.school") Школы
        li
            router-link(:to="Router.routes.home.office.hall") Залы
        li
            ul
                li
                    router-link(:to="Router.routes.home.office.direction") Направления
                li
                    router-link(:to="Router.routes.home.office.subscription") Абонементы
        li
            ul
                li Участники
                li Ученики
                li Преподаватели
                li Администраторы
        li Посещения
        li Отчетность
        li(@click="logout") Выйти
    router-view
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

export default {
    methods: {
        logout() {
            this.Http
                .request(this.Router.uri.user.logout)
                .then(() => {
                    this.User.setUser({});

                    this.$router.push(this.Router.routes.home.auth);
                });
        },
    },
};
</script>