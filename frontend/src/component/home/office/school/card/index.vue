<template lang="pug">
.school(v-if="isReady")
    Info.item(
        :school="school"
        :rules="rules"
        @save="saveSchool"
        @remove="removeSchool()"
    )
    Subscription.item(
        :school="school"
        @save="saveSchool()"
    )
    Direction.item(
        :school="school"
        @save="saveSchool()"
    )
    User.item(
        :school="school"
        @save="saveSchool()"
    )
</template>

<style lang="stylus" scoped>
.school
    display grid
    grid-template-columns repeat(3, 1fr)
    grid-gap 1em
    grid-auto-rows minmax(auto, 500px)

    @media $media.tablet.small
        grid-template-columns repeat(4, 100%)
        grid-auto-rows auto

    .item
        overflow-y auto
        padding 1em
        border-decoration(var(--component-global-paginator-border-color), var(--component-global-paginator-border-radius))

        @media $media.tablet.small
            grid-column 1 / 1

        ::v-deep()
            h3.title
                margin-bottom 1em
                text-align center
                font-weight 400

            .content
                .row:not(:first-child)
                    margin-top 1.25em
</style>

<script>
'use strict';

import Info         from './info/index';
import Direction    from './direction/index';
import User         from './user/index';
import Subscription from './subscription/index';

export default {
    components: {
        Info,
        Direction,
        User,
        Subscription,
    },
    props     : {
        id: {
            type    : Number,
            required: true,
        },
    },
    data() {
        return {
            school: null,
            rules : null,
        };
    },
    created() {
        this.refreshSchool();
    },
    computed  : {
        isReady() {
            return this.school !== null;
        },
    },
    methods   : {
        refreshSchool() {
            const data = {
                id: this.id,
            };
            this.Http
                .request(this.Router.uri.school.get, data)
                .then((_json) => {
                    this.school = _json.school;
                    this.rules  = _json.rules;
                    this.Page.meta.setTitle(this.school.title);
                });
        },
        saveSchool(_files = {}) {
            const data = {
                school: this.school,
            };

            const files = {};
            if (this.Iterable.isNotEmpty(_files)) {
                this.Iterable.each(_files, (_file, _key) => {
                    if (_file) {
                        files[_key] = _file;
                    }
                });
            }
            this.Http
                .request(this.Router.uri.school.save, data, files)
                .then(this.refreshSchool);
        },
        removeSchool() {
            // eslint-disable-next-line
            if (!window.confirm('Удалить школу?') || !window.confirm('Точно удалить школу?')) {
                return;
            }
            this.school.isDeleted = true;

            const data = {
                school: this.school,
            };

            this.Http
                .request(this.Router.uri.school.save, data)
                .then(() => {
                    this.$router.push(this.Router.routes.home.office.school);
                });
        },
    },
};
</script>