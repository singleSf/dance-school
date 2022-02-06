<template lang="pug">
.info
    h3.title Основная информация о школе
    .content
        .row.image-list
            .image-item.is-logo
                img.image(
                    :src="logoFile.file.uri"
                    alt="logo"
                )
                AppFormInput(
                    type="file"
                    placeholder="Логотип"
                    v-model:model="files.logo"
                    :max="rules.files.image.size"
                    :extensions="rules.files.image.extensions"
                )
            .image-item.is-subscription
                img.image(
                    :src="subscriptionFile.file.uri"
                    alt="subscription"
                )
                AppFormInput(
                    type="file"
                    placeholder="Абонемент"
                    v-model:model="files.subscription"
                    :max="rules.files.image.size"
                    :extensions="rules.files.image.extensions"
                )
        .row
            .label Название школы
            AppFormInput(
                type="text"
                placeholder="Название школы"
                v-model:model="school.title"
                :isRequired="true"
                :min="3"
                @change="saveSchool()"
            )
        .row
            .remove-school(@click="removeSchool()") Удалить школу
</template>

<style lang="stylus" scoped>
.info
    flex-basis 500px

    @media $media.tablet.small
        flex-basis 100%

    .content
        .row
            &.image-list
                display flex
                flex-wrap wrap
                justify-content space-around
                gap 25px

                .image-item
                    display flex
                    flex-direction column
                    justify-content flex-end
                    align-items center

                    &.is-logo
                        flex-basis calc(40% - 25px / 2)

                    &.is-subscription
                        flex-basis calc(60% - 25px / 2)

                    @media $media.tablet.small
                        flex-basis 100%

                        .image
                            max-width 100%

                    ::v-deep()
                        .input
                            width auto

                    .image
                        max-width 200px
                        max-height 150px

            .remove-school
                margin-top 50px
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
    emits   : ['save'],
    data() {
        return {
            files: {
                logo        : null,
                subscription: null,
            },
        };
    },
    created() {
        watch(() => this.files, this.saveSchool, {deep: true});
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
    },
};
</script>