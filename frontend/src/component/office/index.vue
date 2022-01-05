<template lang="pug">
div office
div(@click="logout") logout
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

export default {
    methods: {
        logout() {
            this.Http
                .request(this.Router.uri.user.logout)
                .then(() => {
                    this.User.setUser({});
                });
        },
    },
};
</script>