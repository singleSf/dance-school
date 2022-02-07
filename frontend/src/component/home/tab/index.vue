<template lang="pug">
.tab-list
    Tab(
        v-for="tab in tabs"
        :key="tab.id"
        :tab="tab"
    )
</template>

<style lang="stylus" scoped>
.tab-list
    display grid
    padding-top 5px
    background-color var(--body-background-color-default)
    text-align center
    grid-template-columns repeat(4, 1fr)
    grid-gap 1em
</style>

<script>
'use strict';

import Tab from './tab';

export default {
    components: {
        Tab,
    },
    props     : {
        tabs: {
            type    : Array,
            required: true,
        },
    },
};
</script>