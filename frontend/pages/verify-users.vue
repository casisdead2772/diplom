<template>
  <v-container>
    <verify-user></verify-user>
  </v-container>
</template>

<script>
export default {
  components: {
    VerifyUser: () => import('@/components/admin/VerifyUser')
  }
}
</script>

<style scoped>

</style>
