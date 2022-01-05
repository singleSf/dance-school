<template lang="pug">
ul Список направлений
    li(
        v-for="direction in list"
        :key="direction.id"
    ) {{direction.title}}
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
                    title: 'Бачата',
                },
                2: {
                    id   : 2,
                    title: 'Хастл',
                },
            },
        };
    },
};
</script>