<template>
  <v-container>
    <login />
  </v-container>
</template>

<script>
export default {
  components: {
    Login: () => import('@/components/sign-in/Login')
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
