<template>
  <v-container>
    <subjects></subjects>
  </v-container>
</template>

<script>
export default {
  components: {
    Subjects: () => import('@/components/admin/Subjects')
  }
}
</script>

<style scoped>

</style>
