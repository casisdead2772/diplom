<template>
  <v-container fluid>
    <reserved-lessons />
  </v-container>
</template>

<script>
export default {
  components: {
    ReservedLessons: () => import('@/components/lessons/ReservedLessons')
  },
  middleware: ['auth', 'teacher']
}
</script>
