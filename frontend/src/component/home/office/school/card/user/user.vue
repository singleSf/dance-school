<template lang="pug">
.user
    AppFontAwesomeIcon.icon.is-admin(
        :icon="['fas', 'user-cog']"
        :class="adminClasses"
        title="Администратор"
        @click="toggleAdminUser()"
    )
    AppFontAwesomeIcon.icon.is-teacher(
        title="Преподаватель"
        :class="teacherClasses"
        :icon="['fas', 'user-graduate']"
        @click="toggleTeacherUser()"
    )
    AppFontAwesomeIcon.icon.is-student(
        title="Ученик"
        :class="studentClasses"
        :icon="['fas', 'user']"
        @click="toggleStudentUser()"
    )
    span.id \#{{user.id}}
    span.title {{user.title}}
</template>

<style lang="stylus" scoped>
.user
    display flex
    justify-content space-between

    .icon
        flex-basis 25px
        user-select none

    .id
        flex-basis 30px

    .title
        flex-basis calc(100% - 30px - 25px * 3)
</style>

<script>
'use strict';

export default {
    props   : {
        user: {
            type   : Object,
            require: true,
        },
    },
    emits   : ['save'],
    computed: {
        adminClasses() {
            return {
                'is-active': this.user.isAdmin,
            };
        },
        teacherClasses() {
            return {
                'is-active': this.user.isTeacher,
            };
        },
        studentClasses() {
            return {
                'is-active': this.user.isStudent,
            };
        },
    },
    methods : {
        saveUser(_changeRole) {
            this.$emit('save', this.user, {[_changeRole]: !this.user[_changeRole]});
        },
        toggleAdminUser() {
            this.saveUser('isAdmin');
        },
        toggleTeacherUser() {
            this.saveUser('isTeacher');
        },
        toggleStudentUser() {
            this.saveUser('isStudent');
        },
    },
};
</script>