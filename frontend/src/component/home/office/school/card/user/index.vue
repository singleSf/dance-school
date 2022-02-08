<template lang="pug">
.user-list
    h3.title
        span Пользователи ({{countUsers}})
        AppFontAwesomeIcon.icon.create-new-user(
            :icon="['far', 'address-card']"
            @click="toggleCreateNewUser()"
            title="Создать нового пользователя"
        )

    .content.create-new-user(v-if="newUser.isOpen")
        .row
            AppFormInput.search(
                type="search"
                placeholder="ФИ нового пользователя"
                v-model:model="newUser.title"
            )
            .similar-list(v-if="!isEmptySimilarUsers")
                .title Возможно, этот пользователь уже существует?
                User(
                    v-for="user in similarUsers"
                    :key="user.id"
                    :user="user"
                )
        .row.role-list
            .role(@click="toggleAdminUser()")
                AppFontAwesomeIcon.icon.is-admin(
                    title="Администратор"
                    size="2x"
                    :icon="['fas', 'user-cog']"
                    :class="newUserAdminClasses"
                )
                .title Администратор
            .role(@click="toggleTeacherUser()")
                AppFontAwesomeIcon.icon.is-teacher(
                    title="Преподаватель"
                    size="2x"
                    :class="newUserTeacherClasses"
                    :icon="['fas', 'user-graduate']"
                )
                .title Преподаватель
            .role(@click="toggleStudentUser()")
                AppFontAwesomeIcon.icon.is-student(
                    title="Ученик"
                    size="2x"
                    :class="newUserStudentClasses"
                    :icon="['fas', 'user']"
                )
                .title Ученик
        .row.button-list
            AppFormButtonSubmit.button(
                :isDisabled="false"
                @click="toggleCreateNewUser()"
            ) Отмена
            AppFormButtonSubmit.button(
                :isDisabled="!isValidNewUser"
                @click="createNewUser()"
            ) Создать
    .content(v-else)
        .row
            AppFormInput.search(
                type="search"
                placeholder="Поиск"
                v-model:model="search"
            )
            AppFormInput.self-user(
                type="checkbox"
                v-model:model="isShowSelfUser"
            ) Показывать только учеников школы
        .row
            .list
                User(
                    v-for="user in users"
                    :key="user.id"
                    :user="user"
                )
</template>

<style lang="stylus" scoped>
.user-list
    grid-column 3 / 4

    h3.title
        display flex
        justify-content center
        align-items center

        .create-new-user
            margin-left 1em
            cursor pointer

    .create-new-user
        .similar-list
            font-size 0.75em

            .title
                margin 0.75em 0

        .role-list
            display flex
            justify-content space-around

            .role
                flex-basis 100px
                text-align center
                cursor pointer
                user-select none

                .title
                    font-size 0.75em

        .button-list
            display flex
            justify-content space-between

            .button
                flex-basis 45%


    .self-user
        margin-top 0.5em
        font-size 0.75em

    ::v-deep()
        .icon
            cursor pointer

            &.is-active
                &.is-admin
                    color red

                &.is-teacher
                    color orange

                &.is-student
                    color #71ff42
</style>

<script>
'use strict';

import User from './user';

export default {
    components: {
        User,
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
            search        : '',
            isShowSelfUser: true,
            newUser       : {
                isOpen   : false,
                title    : '',
                isAdmin  : false,
                isTeacher: false,
                isStudent: false,
            },
        };
    },
    computed  : {
        users() {
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

            let users = [
                ...admins.sort(this.sortUsers),
                ...teachers.sort(this.sortUsers),
                ...students.sort(this.sortUsers),
            ];

            if (!this.isShowSelfUser) {
                users = users.concat(others.sort(this.sortUsers));
            }

            return users;
        },
        countUsers() {
            return this.Iterable.count(this.users);
        },
        similarUsers() {
            if (!this.newUser.title) {
                return [];
            }

            const admins   = [];
            const teachers = [];
            const students = [];
            const others   = [];
            this.Iterable.each(this.school.users, (_user) => {
                if (_user.title.toLowerCase().indexOf(this.newUser.title.toLowerCase()) === -1) {
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
                ...admins.sort(this.sortUsers),
                ...teachers.sort(this.sortUsers),
                ...students.sort(this.sortUsers),
                ...others.sort(this.sortUsers),
            ];
        },
        isEmptySimilarUsers() {
            return this.Iterable.isEmpty(this.similarUsers);
        },
        newUserAdminClasses() {
            return {
                'is-active': this.newUser.isAdmin,
            };
        },
        newUserTeacherClasses() {
            return {
                'is-active': this.newUser.isTeacher,
            };
        },
        newUserStudentClasses() {
            return {
                'is-active': this.newUser.isStudent,
            };
        },
        isValidNewUser() {
            return this.newUser.title.length >= 20 && (this.newUser.isAdmin || this.newUser.isTeacher || this.newUser.isStudent);
        },
    },
    methods   : {
        sortUsers(_userA, _userB) {
            return _userA.title.localeCompare(_userB.title);
        },
        toggleCreateNewUser() {
            this.newUser.isOpen    = !this.newUser.isOpen;
            this.newUser.title     = '';
            this.newUser.isAdmin   = false;
            this.newUser.isTeacher = false;
            this.newUser.isStudent = false;
        },
        createNewUser() {
        },
        toggleAdminUser() {
            this.newUser.isAdmin = !this.newUser.isAdmin;
        },
        toggleTeacherUser() {
            this.newUser.isTeacher = !this.newUser.isTeacher;
        },
        toggleStudentUser() {
            this.newUser.isStudent = !this.newUser.isStudent;
        },
    },
};
</script>