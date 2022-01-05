<template lang="pug">
AppFormForm(
    v-model:isValid="form.isValid"
)
    .columns
        AppFormInput(
            type="text"
            placeholder="Логин"
            v-model:model="form.login"
            :isRequired="true"
        ) Ваш логин
    .columns
        AppFormInput(
            type="password"
            placeholder="Пароль"
            v-model:model="form.password"
            :isRequired="true"
        )
    .columns
        AppFormButtonSubmit(
            :isDisabled="!form.isValid"
            @click="eventSendForm()"
        ) Отправить форму
</template>

<style lang="stylus" scoped>
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
                    }
                });
        },
    },
};
</script>