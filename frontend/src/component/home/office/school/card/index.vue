<template lang="pug">
div {{school}}
</template>

<style lang="stylus" scoped>

</style>

<script>
'use strict';

export default {
    props  : {
        id: {
            type    : Number,
            required: true,
        },
    },
    data() {
        return {
            school: null,
        };
    },
    created() {
        this.refreshSchool();
    },
    methods: {
        refreshSchool() {
            const data = {
                id: this.id,
            };
            this.Http
                .request(this.Router.uri.school.get, data)
                .then((_json) => {
                    this.school = _json.school;
                    this.Page.meta.setTitle(this.school.title);
                });
        },
        saveSchool(_school) {
            const data = {
                school: _school,
            };

            this.Http
                .request(this.Router.uri.school.save, data)
                .then(this.refreshList);
        },
        removeSchool(_school) {
            // eslint-disable-next-line
            if (!window.confirm('Удалить школу?')) {
                return;
            }
            _school.isDelete = true;

            const data = {
                school: _school,
            };

            this.Http
                .request(this.Router.uri.school.save, data)
                .then(this.refreshSchool);
        },
    },
};
</script>