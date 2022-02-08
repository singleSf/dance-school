<template lang="pug">
.subscription
    h3.title Абонементы ({{school.count.subscription}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.subscription
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