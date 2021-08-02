<template>
  <v-container grid-list-md>
    <quiz :quiz-id="lessonId" />
  </v-container>
</template>

<script>

export default {
  components: {
    Quiz: () => import('@/components/quiz/Quiz')
  },
  middleware: ['auth'],
  data: () => ({
    isLoading: false,
    lessonId: ''
  }),
  created () {
    this.getQuizId()
  },
  methods: {
    getQuizId () {
      this.lessonId = this.$route.params.id
    }
  }
}
</script>

<style>
.rounded-card{
  border-radius:7px;
}
</style>
