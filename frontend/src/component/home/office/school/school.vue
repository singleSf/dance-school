<template lang="pug">
.row(@click="toSchool()")
    .id
        .label #
        .content {{school.id}}
    .title
        .content {{school.title}}
    .count
        .label Залы:
        .content {{school.count.hole}}
    .count
        .label Направления:
        .content {{school.count.direction}}
    .count
        .label Ученики:
        .content {{school.count.student}}
    .count
        .label Преподаватели:
        .content {{school.count.teacher}}
    .count
        .label Абонементы:
        .content {{school.count.subscription}}

</template>

<style lang="stylus" scoped>
.row
    border-top 1px solid var(--component-global-ui-form-button-border-color)
    cursor pointer

    .label
        display none

    @media $media.tablet.small
        .id, .title, .count
            display flex
            flex-basis 50%
            text-align left

            .label
                display block
                margin-right 15px

        .id
            display none

        .title
            flex-basis 100%
            font-weight 700

</style>

<script>
'use strict';

export default {
    props   : {
        school: {
            type    : Object,
            required: true,
        },
    },
    computed: {
        uri() {
            const route  = this.Iterable.clone(this.Router.routes.home.office.schoolCard);
            route.params = {
                id: this.school.id,
            };

            return route;
        },
    },
    methods : {
        toSchool() {
            this.$router.push(this.uri);
        },
    },
};
</script>