<template lang="pug">
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

export default {
    beforeCreate() {
        this.Http
            .request(this.Router.uri.user.logout)
            .then(() => {
                this.User.setUser({});

                this.$router.push(this.Router.routes.home.auth);
            });
    },
};
</script>