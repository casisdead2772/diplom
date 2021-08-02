<template>
  <v-container>
    <v-card
      :loading="isLoading"
      width="auto"
      max-width="600"
      class="mx-auto my-3"
      elevation="0"
      outlined
    >
      <v-toolbar flat>
        <v-toolbar-title>My Quizzes</v-toolbar-title>
      </v-toolbar>
      <v-divider />
      <v-flex v-for="(test, index) in quizItems" :key="index" xs12>
        <v-card class="rounded-card ma-4 pa-4" outlined elevation="8">
          <v-card-title primary-title class="headline primary--text">
              Quiz: {{ test.title }}
          </v-card-title>
          <v-card-text class="font-weight-regular mt-0 pt-0">
            Number of questions: {{ test.questions.length }}
          </v-card-text>
          <v-row wrap class="justify-center">
            <v-btn class="success ma-2" @click="loadTest(test.id)">
              Take the quiz
            </v-btn>
          </v-row>
        </v-card>
      </v-flex>
    </v-card>
  </v-container>
</template>

<script>

export default {
  data: () => ({
    isLoading: false,
    id: null,
    editDialog: false,
    errors: null
  }),
  watch: {
    options: {
      handler () {
        this.getQuizzes()
      },
      deep: true
    }
  },
  created () {
    this.getQuizzes()
  },
  methods: {
    async getQuizzes () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('quiz-user')
        if (data !== undefined) {
          this.quizItems = data
        }
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    loadTest (quizId) {
      this.$router.push({ name: 'takequiz-id', params: { id: quizId } })
    }
  }
}
</script>
