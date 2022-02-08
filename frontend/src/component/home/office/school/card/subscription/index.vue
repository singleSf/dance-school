<template lang="pug">
.subscription-list
    h3.title Абонементы ({{school.count.subscription}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.subscription-list
    grid-column 2 / 4
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