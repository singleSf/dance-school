<template lang="pug">
.participant
    h3.title Участники ({{school.count.participant}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.participant
    grid-column 4 / 5
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