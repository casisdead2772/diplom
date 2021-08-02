<template>
  <v-container>
    <registration />
  </v-container>
</template>

<script>
export default {
  components: {
    Registration: () => import('@/components/sign-up/Registration')
  },
  middleware: 'guest',
  computed: {
    xsStyle () {
      if (this.$vuetify.breakpoint.xs) {
        return 'height:0vh'
      } else {
        return 'height:100vh'
      }
    }
  },
  mounted () {
    this.$nextTick(() => {
      this.$nuxt.$loading.start()
      setTimeout(() => this.$nuxt.$loading.finish(), 500)
    })
  }
}
</script>

<style scoped>
.center {
  position: absolute;
  left: 50%;
  bottom: 50%;
  -ms-transform: translate(-50%, 35%);
  transform: translate(-50%, 35%);
}
</style>
