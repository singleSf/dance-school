<template lang="pug">
li.tab
    router-link.link(
        :to="tab.route"
    ) {{tab.title}}
</template>

<style lang="stylus" scoped>
.tab
    flex-basis 175px
    background-color var(--background-color-tab)
    text-align center
    border-decoration(var(--component-global-paginator-border-color), var(--component-global-paginator-border-radius))

    &:hover {
        background-color var(--background-color-tab-hover)
    }

    .link
        display block
        padding 5px
</style>

<script>
'use strict';

export default {
    props: {
        tab: {
            type    : Object,
            required: true,
        },
    },
};
</script>