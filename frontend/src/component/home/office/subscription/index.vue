<template lang="pug">
ul Список уровней
    li(
        v-for="subscription in list"
        :key="subscription.id"
    ) {{subscription.title}}
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
                    title: 'Разовый',
                },
                2: {
                    id   : 2,
                    title: 'Начинающий',
                },
                3: {
                    id   : 3,
                    title: 'Средний',
                },
                4: {
                    id   : 4,
                    title: 'Индив',
                },
                5: {
                    id   : 5,
                    title: 'Футворк',
                },
            },
        };
    },
};
</script>