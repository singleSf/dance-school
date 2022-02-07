<template lang="pug">
.row
    .id
        .label #
        .content {{school.id}}
    .title
        .content {{school.title}}
    .count(v-if="false")
        .label Залы:
        .content {{school.count.hall}}
    .count
        .label Абонементы:
        .content {{school.count.subscription}}
    .count
        .label Участники:
        .content {{school.count.participant}}
    .count
        .label Направления:
        .content {{school.count.direction}}
    .count
        .label Преподаватели:
        .content {{school.count.teacher}}
    .count
        .label Администраторы:
        .content {{school.count.admin}}

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
            justify-content space-between
            flex-basis 40%
            text-align left

            .label
                display block

        .id
            display none

        .title
            flex-basis 100%
            margin-bottom 0.5em
            font-weight 700

</style>

<script>
'use strict';

export default {
    props: {
        school: {
            type    : Object,
            required: true,
        },
    },
};
</script>