<template lang="pug">
template(v-if="isReady")
    Tabs(
        :tabs="tabs"
    )
    .office
        h1.title {{Page.meta.title}}
        router-view
</template>

<style lang="stylus" scoped>
.office
    h1.title
        padding 1.25em
        text-align center
</style>

<script>
'use strict';

import Tabs    from '../tab/index';
import {unref} from 'vue';

export default {
    components: {
        Tabs,
    },
    data() {
        return {
            tabs: [
                {
                    id   : 1,
                    title: 'Школы',
                    route: this.Router.routes.home.office.school,
                },
                {
                    id   : 2,
                    title: 'Посещения',
                    route: '',
                },
                {
                    id   : 3,
                    title: 'Отчетность',
                    route: '',
                },
                {
                    id   : 4,
                    title: 'Выйти',
                    route: this.Router.routes.home.logout,
                },
            ],
        };
    },
    computed  : {
        isReady() {
            return !unref(this.$router.currentRoute).meta.isAuth || this.User.isAuth;
        },
    },
};
</script>