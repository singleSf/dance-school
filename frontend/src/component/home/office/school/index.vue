<template lang="pug">
.school-list
    .list.head
        .row
            .id #
            .title Название школы
            .count(v-if="false") Залы
            .count Абонементы
            .count Ученики
            .count Направления
            .count Преподаватели
            .count Администраторы
    .list.body
        SchoolComponent(
            v-for="school in list"
            :key="school.id"
            :school="school"
            @click="toSchool(school)"
        )

    .create-school
        AppFormButtonButton(@click="createSchool()") Добавить школу
</template>

<style lang="stylus" scoped>
.school-list
    .list
        &.head
            @media $media.tablet.small
                display none

            .row .id
                text-align left

        ::v-deep()
            .row
                display flex
                justify-content space-between
                padding 0.5em 0

                @media $media.tablet.small
                    flex-wrap wrap

                @media $media.tabletBigOrDesktop
                    .id
                        flex-basis 50px

                    .title
                        flex-grow 1

                    .count
                        flex-basis 150px
                        text-align center

    .create-school
        margin-top 1em
</style>

<script>
'use strict';

import SchoolComponent from './school';

export default {
    components: {
        SchoolComponent,
    },
    data() {
        return {
            list: {},
        };
    },
    created() {
        this.refreshList();
    },
    methods   : {
        refreshList() {
            this.Http
                .request(this.Router.uri.school.list)
                .then((_json) => {
                    this.list = _json.list;
                });
        },
        createSchool() {
            const data = {
                school: {
                    title: 'Новая школа',
                },
            };

            this.Http
                .request(this.Router.uri.school.save, data)
                .then((_json) => {
                    this.toSchool(_json.school);
                });
        },
        toSchool(_school) {
            const route  = this.Iterable.clone(this.Router.routes.home.office.schoolCard);
            route.params = {
                id: _school.id,
            };

            this.$router.push(route);
        },
    },
};
</script>