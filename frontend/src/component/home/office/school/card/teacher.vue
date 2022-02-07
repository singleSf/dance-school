<template lang="pug">
.teacher
    h3.title Преподаватели ({{school.count.teacher}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.teacher
    grid-column 3 / 4
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
    emits: ['save', 'remove'],
};
</script>