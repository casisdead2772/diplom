<template>
  <user-quiz-list></user-quiz-list>
</template>

<script>
export default {
  components: {
    UserQuizList: () => import('@/components/quiz/UserQuizList')
  }
}
</script>

<style scoped>

</style>
