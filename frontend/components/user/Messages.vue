<template>
  <v-btn icon small class="ml-5" @click="toMessages">
    <v-icon>mdi-forum</v-icon>
  </v-btn>
</template>

<script>
export default {
  name: 'Messages',
  methods: {
    toMessages () {
      this.$nextTick(() => this.$router.push({ path: '/messages' }).catch(() => {
      }))
    }
  }
}
</script>

<style scoped>

</style>
