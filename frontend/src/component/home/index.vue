<template lang="pug">
AppFlashMessenger

main(v-if="isReady")
    Office(v-if="User.isAuth")
    Auth(v-else)
</template>

<style lang="stylus" scoped>
</style>

<script>
'use strict';

import Auth   from '../auth/index';
import Office from '../office/index';

export default {
    components: {
        Auth,
        Office,
    },
    data() {
        return {
            isReady: false,
        };
    },
    beforeCreate() {
        this.Http
            .request(this.Router.uri.user.get)
            .then((_json) => {
                if (_json.user) {
                    this.User.setUser(_json.user);
                }

                this.isReady = true;
            });
    },
};
</script>