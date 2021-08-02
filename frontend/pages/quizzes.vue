<template>
  <v-container>
    <quiz-list class="center" />
  </v-container>
</template>

<script>
export default {
  components: {
    QuizList: () => import('@/components/quiz/QuizList')
  },
  middleware: ['auth']
}
</script>

<style scoped>

</style>
