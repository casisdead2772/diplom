<template>
  <div class="d-flex justify-content-center">
    <div v-if="showScore">
      <v-card
        v-if="quizItem.questions.length > 0"
        title="Results"
        style="max-width: 20rem;"
      >
        <v-card-title class="headline">
          You Scored {{ score }} of {{ quizItem.questions.length }}
        </v-card-title>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="green darken-1"
            @click="startQuiz = true
                    showScore = false
                    currentQuestion = 0
                    score = 0
                    startQuizFunc()"
          >
            Try again
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
    <div v-else class="card-q">
      <span v-if="!startQuiz">
        <v-card
          v-if="!startQuiz"
          width="auto"
          max-width="600"
          class="mx-auto my-3"
          elevation="0"
          outlined
        >
          <v-card-title>Quiz: {{ quizItem.title }} </v-card-title>
          <v-btn @click="startQuizFunc()">Start Quiz</v-btn>
        </v-card>
      </span>
      <span v-else>
        <v-card
          style="max-width: 20rem;"
          class="mb-2"
        >
          <v-card-text v-if="quizItem.questions.length > 0">
            Question No.{{ currentQuestion + 1 }} of {{ quizItem.questions.length }}
          </v-card-text>
          <v-card-text>
            <h1>{{ quizItem.questions[currentQuestion].title }}</h1>
          </v-card-text>
          <br>
          <v-progress-linear
            v-model="countDown"
            height="4px"
          />

          <v-card-text>
            <span style="font-size: 20px;"><h3>{{ countDown }} </h3></span>
          </v-card-text>
          <div class="answer-section">
            <v-btn v-for="(option, index) in quizItem.questions[currentQuestion].answers" :key="index" class="ma-3 v-btn--outlined" variant="primary" @click="handleAnswerClick(option.correct)">{{ option.answerTitle }}</v-btn>
          </div>
        </v-card>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: ['quizId'],
  data () {
    return {
      lessons: this.lessons,
      currentQuestion: 0,
      showScore: false,
      score: 0,
      countDown: 100,
      timer: null,
      startQuiz: false,
      quizItem: {
        title: '',
        questions: []
      }
    }
  },
  watch: {
    options: {
      handler () {
        this.getQuiz()
      },
      deep: true
    }
  },
  created () {
    this.getQuiz()
  },
  methods: {
    async getQuiz () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('quiz/' + this.quizId)
        this.quizItem = data[0]
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    startQuizFunc () {
      this.startQuiz = true
      this.countDownTimer()
    },
    handleAnswerClick (isCorrect) {
      clearTimeout(this.timer)
      const nextQuestion = this.currentQuestion + 1
      if (isCorrect) {
        this.score = this.score + 1
      }
      if (nextQuestion < this.quizItem.questions.length) {
        this.currentQuestion = nextQuestion
        this.$store.state.questionAttended = this.currentQuestion
        this.countDown = 100
        this.countDownTimer()
      } else {
        this.showScore = true
      }
    },
    countDownTimer () {
      if (this.countDown > 0) {
        this.timer = setTimeout(() => {
          this.countDown -= 1
          this.countDownTimer()
        }, 1000)
      } else {
        this.handleAnswerClick(false)
      }
    }
  }

}
</script>

<style scoped>
.v-card{
  min-width: 100%;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 10px 10px 42px 0px rgba(0, 0, 0, 0.75);
}
.card-q{
  min-width: 60%;
}
.ans-option-btn{
  min-width: 50%;
  font-size: 16px;
  color: #ffffff;
  align-items: center;
  cursor: pointer;
  margin-bottom: 5px;
}
.answer-section {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.timer-text {
  background: rgb(230, 153, 12);
  padding: 15px;
  margin-top: 20px;
  margin-right: 20px;
  border: 5px solid rgb(255, 189, 67);
  border-radius: 15px;
  text-align: center;
}
.card-img, .card-img-top {
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
  height: 350px;
}
/* .ans-option-btn {
  width: 100%;
  font-size: 16px;
  color: #ffffff;
  background-color: #252d4a;
  border-radius: 15px;
  display: flex;
  padding: 5px;
  justify-content: flex-start;
  align-items: center;
  border: 5px solid #234668;
  cursor: pointer;
} */
</style>
