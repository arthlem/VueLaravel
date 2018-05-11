<template>
    <v-app>
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </v-app>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>

<script>
export default {};
</script>