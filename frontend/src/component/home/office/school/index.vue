<template lang="pug">
ul Список школ
    li(
        v-for="school in list"
        :key="school.id"
    ) {{school.title}}
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

export default {
    data() {
        return {
            list: {
                1: {
                    id   : 1,
                    title: 'LRN',
                },
                2: {
                    id   : 2,
                    title: 'CASA LATINA',
                },
            },
        };
    },
};
</script>