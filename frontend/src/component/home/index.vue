<template lang="pug">
AppFlashMessenger

main
    router-view
</template>

<style lang="stylus" scoped>
@import '../../style/app.styl'
</style>

<script>
'use strict';

export default {
    beforeCreate() {
        this.Http
            .request(this.Router.uri.user.get)
            .then((_json) => {
                if (_json.user) {
                    this.User.setUser(_json.user);
                } else {
                    this.$router.push(this.Router.routes.home.auth);
                }
            });
    },
};
</script>