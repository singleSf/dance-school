<template lang="pug">
.info
    h3.title Основная информация о школе
    .content
        .row.image-list
            .item
                img.image(
                    :src="logoFile.file.uri"
                    alt="logo"
                )
                AppFormInput(
                    type="file"
                    placeholder="Выбрать новый логотип"
                    v-model:model="files.logo"
                    :max="rules.file.image.size"
                    :extensions="rules.file.image.extensions"
                )
            .item
                img.image(
                    :src="subscriptionFile.file.uri"
                    alt="subscription"
                )
                AppFormInput(
                    type="file"
                    placeholder="Выбрать новый вид абонемента"
                    v-model:model="files.subscription"
                    :max="rules.file.image.size"
                    :extensions="rules.file.image.extensions"
                )
        .row
            .label Название школы
            AppFormInput(
                type="text"
                placeholder="Название школы"
                v-model:model="school.title"
                :isRequire="true"
                :min="3"
                @change="saveSchool()"
            )
        .row
            .remove-school(@click="removeSchool()") Удалить школу
</template>

<style lang="stylus" scoped>
.info
    grid-column 1 / 2

    @media $media.tablet.small
        flex-basis 100%

    .content
        .row
            &.image-list
                display flex
                flex-wrap wrap
                justify-content space-around
                gap 2em

                .item
                    display flex
                    flex-basis 100%
                    flex-direction column
                    justify-content flex-end
                    align-items center

                    .image
                        max-width 100%
                        max-height 150px

            .remove-school
                margin-top 5em
                color var(--link-color)
                font-size 12px
                cursor pointer
</style>

<script>
'use strict';

import {watch} from 'vue';

export default {
    props   : {
        school: {
            type    : Object,
            required: true,
        },
        rules : {
            type    : Object,
            required: true,
        },
    },
    emits   : ['save', 'remove'],
    data() {
        return {
            files: {
                logo        : null,
                subscription: null,
            },
        };
    },
    created() {
        watch(this.files, this.saveSchool, {deep: true});
    },
    computed: {
        logoFile() {
            return this.Iterable.findOneBy(this.school.files, {isLogo: true});
        },
        subscriptionFile() {
            return this.Iterable.findOneBy(this.school.files, {isSubscription: true});
        },
    },
    methods : {
        saveSchool() {
            this.$emit('save', this.files);
        },
        removeSchool() {
            this.$emit('remove');
        },
    },
};
</script>