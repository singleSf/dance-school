<template lang="pug">
AppFlashMessenger

main
    router-view
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

export default {
    beforeCreate() {
        this.Http
            .request(this.Router.uri.user.get)
            .then((_json) => {
                let route = this.Router.routes.home.auth;
                if (_json.user) {
                    this.User.setUser(_json.user);

                    route = this.Router.routes.home.office.office;
                }

                this.$router.push(route);
            });
    },
};
</script>