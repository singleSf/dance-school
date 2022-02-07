<template lang="pug">
.admin
    h3.title Администраторы ({{school.count.admin}})
    .content
        .row test
</template>

<style lang="stylus" scoped>
.admin
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