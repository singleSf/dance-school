<template lang="pug">
.user
    h3.title
        span Пользователи ({{countUsers}})
        AppFontAwesomeIcon.icon.create-new-user(
            :icon="['far', 'address-card']"
            @click="preCreateNewUser()"
            title="Создать нового пользователя"
        )

    .content(v-if="newUser.isOpen")
        .row
            AppFormInput.search(
                type="search"
                placeholder="ФИО нового пользователя"
                v-model:model="newUser.title"
                :min="20"
            )
        .row
            AppFormButtonSubmit.submit(
                :isDisabled="false"
                @click="createNewUser()"
            ) Создать
    .content(v-else)
        .row
            AppFormInput.search(
                type="search"
                placeholder="Поиск"
                v-model:model="search"
            )
        .row
            .list
                User(
                    v-for="user in users"
                    :key="user.id"
                    :user="user"
                )
</template>

<style lang="stylus" scoped>
.user
    grid-column 3 / 4

    h3.title
        display flex
        justify-content center
        align-items center

        .create-new-user
            margin-left 1em
            cursor pointer

</style>

<script>
'use strict';

import User       from './user';
import PseudoLink from '../../../../helper/pseudo-link';


export default {
    components: {
        User,
        PseudoLink,
    },
    props     : {
        school: {
            type    : Object,
            required: true,
        },
    },
    emits     : ['save'],
    data() {
        return {
            search : '',
            newUser: {
                isOpen: false,
                title : '',
            },
        };
    },
    computed  : {
        users() {
            const sortUsers = (_userA, _userB) => _userA.title.localeCompare(_userB.title);

            const admins   = [];
            const teachers = [];
            const students = [];
            const others   = [];
            this.Iterable.each(this.school.users, (_user) => {
                if (this.search
                    && (
                        _user.title.toLowerCase().indexOf(this.search.toLowerCase()) === -1
                        && _user.id.toString() !== this.search
                    )
                ) {
                    return;
                }

                if (_user.isAdmin) {
                    admins.push(_user);
                } else if (_user.isTeacher) {
                    teachers.push(_user);
                } else if (_user.isStudent) {
                    students.push(_user);
                } else {
                    others.push(_user);
                }
            });

            return [
                ...admins.sort(sortUsers),
                ...teachers.sort(sortUsers),
                ...students.sort(sortUsers),
                ...others.sort(sortUsers),
            ];
        },
        countUsers() {
            return this.Iterable.count(this.users);
        },
    },
    methods   : {
        preCreateNewUser() {
            this.newUser.isOpen = !this.newUser.isOpen;
            this.newUser.title  = '';
        },
        createNewUser() {

        },
    },
};
</script>