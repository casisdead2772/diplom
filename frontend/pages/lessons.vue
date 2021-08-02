<template>
  <v-container fluid>
    <lessons />
  </v-container>
</template>

<script>
export default {
  components: {
    Lessons: () => import('@/components/lessons/Lessons')
  },
  middleware: ['auth']
}
</script>
