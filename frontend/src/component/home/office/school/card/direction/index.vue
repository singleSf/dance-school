<template lang="pug">
.direction-list
    h3.title Направления ({{school.count.direction}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.direction-list
    grid-column 1 / 3
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
    emits: ['save'],
};
</script>