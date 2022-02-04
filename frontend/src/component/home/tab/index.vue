<template lang="pug">
ul.tab-list
    Tab(
        v-for="tab in tabs"
        :key="tab.id"
        :tab="tab"
    )
</template>

<style lang="stylus" scoped>
.tab-list
    display flex
    justify-content space-between
    margin-top 5px
    background-color var(--body-background-color-default)

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