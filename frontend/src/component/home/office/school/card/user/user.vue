<template lang="pug">
.user
    AppFontAwesomeIcon.icon.is-admin(
        :icon="['fas', 'user-cog']"
        :class="adminClasses"
        title="Администратор"
    )
    AppFontAwesomeIcon.icon.is-teacher(
        title="Преподаватель"
        :class="teacherClasses"
        :icon="['fas', 'user-graduate']"
    )
    AppFontAwesomeIcon.icon.is-student(
        title="Ученик"
        :class="studentClasses"
        :icon="['fas', 'user']"
    )
    span.id \#{{user.id}}
    span.title {{user.title}}
</template>

<style lang="stylus" scoped>
.user
    display flex
    justify-content space-between

    .icon
        flex-basis 30px

    .id
        flex-basis 30px

    .title
        flex-basis calc(100% - 30px - 30px * 3)
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
};
</script>