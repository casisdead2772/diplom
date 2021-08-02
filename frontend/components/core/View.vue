<template>
  <v-main color="navigation">
    <v-fade-transition mode="out-in">
      <nuxt />
    </v-fade-transition>
  </v-main>
</template>

<script>
export default {
  name: 'CoreView'
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
