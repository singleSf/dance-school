<template lang="pug">
.school(v-if="isReady")
    Info.item(
        :school="school"
        :rules="rules"
    )
    .item
        h3.title Направления ({{school.count.direction}})
    .item
        h3.title Ученики ({{school.count.student}})
    .item
        h3.title Преподаватели ({{school.count.teacher}})
    .item
        h3.title Администраторы ({{school.count.admin}})
    .item
        h3.title Абонементы ({{school.count.subscription}})
</template>

<style lang="stylus" scoped>
.school
    display flex
    flex-wrap wrap
    gap 15px

    .item
        padding 15px
        border-decoration(var(--component-global-paginator-border-color), var(--component-global-paginator-border-radius))

        ::v-deep()
            h3.title
                margin-bottom 15px
                text-align center
                font-weight 400

            .content
                .row
                    margin-top 15px
</style>

<script>
'use strict';

import Info from './info';

export default {
    components: {
        Info,
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
        saveSchool() {
            const data  = {
                school: this.school,
            };
            const files = {};
            /*
                        this.Iterable.each(this.files, (_file, _key) => {
                            if (_file) {
                                files[_key] = _file;

                                this.files[_key] = null;
                            }
                        });
            */
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