<template lang="pug">
AppFormForm.form(
    v-model:isValid="form.isValid"
)
    AppFormInput.input(
        type="text"
        placeholder="Логин"
        v-model:model="form.login"
        :isRequire="true"
        :min="6"
    )
    AppFormInput.input(
        type="password"
        placeholder="Пароль"
        v-model:model="form.password"
        :isRequire="true"
        :min="6"
    )
    AppFormButtonSubmit.submit(
        :isDisabled="!form.isValid"
        @click="eventSendForm()"
    ) Авторизоваться
</template>

<style lang="stylus" scoped>
.form
    margin auto
    width 300px

    .input
        margin-bottom 0.5em

    .submit
        width 100%
</style>

<script>
'use strict';

export default {
    data() {
        return {
            form: {
                isValid : false,
                login   : '',
                password: '',
            },
        };
    },
    methods: {
        eventSendForm() {
            const data = {
                login   : this.form.login,
                password: this.form.password,
            };

            this.Http
                .request(this.Router.uri.user.auth, data)
                .then((_json) => {
                    if (_json.user) {
                        this.User.setUser(_json.user);

                        this.$router.push(this.Router.routes.home.office.office);
                    }
                });
        },
    },
};
</script>