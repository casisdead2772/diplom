<template>
  <div id="tutors">
    <v-container>
      <find-tutor-filter />
    </v-container>
  </div>
</template>

<script>

export default {
  name: 'Tutors',
  components: {
    FindTutorFilter: () => import('@/components/find-tutor/FindTutorFilter')
  }
}
</script>

<style scoped>

</style>
