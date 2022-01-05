<template lang="pug">
ul Список залов
    li(
        v-for="hall in list"
        :key="hall.id"
    ) {{hall.title}}
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
                    title: 'ЦУМ',
                },
                2: {
                    id   : 2,
                    title: 'ДЗ. 60',
                },
            },
        };
    },
};
</script>