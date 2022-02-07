<template lang="pug">
AppFlashMessenger

main.main
    router-view
</template>

<style lang="stylus" scoped>
@import '../../style/app.styl'

.main
    padding 0.25em 0

    @media $media.tablet.big
        padding 0.25em 1.5em
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