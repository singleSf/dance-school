<template lang="pug">
router-link.tab(
    :to="tab.route"
) {{tab.title}}
</template>

<style lang="stylus" scoped>
.tab
    display block
    padding 5px
    background-color var(--background-color-tab)
    border-decoration(var(--component-global-paginator-border-color), var(--component-global-paginator-border-radius))

    &:hover {
        background-color var(--background-color-tab-hover)
    }
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