<template>
  <v-container>
    <v-card
      :loading="isLoading"
      class="mx-auto pb-5"
      max-width="600"
      elevation="0"
      outlined
    >
      <v-toolbar flat>
        <v-row align="center" justify="center" class="mx-3">
          <v-toolbar-title>My Quizzes</v-toolbar-title>
          <v-spacer />
          <v-btn
            justify="end"
            color="primary"
            dark
            @click="onAddQuiz"
          >
            Add Quiz
          </v-btn>
        </v-row>
      </v-toolbar>
      <v-divider />
      <v-dialog v-model="editDialog">
        <template v-slot:activator="{ on, attrs }">
          <v-list>
            <v-list-item v-for="(test, index) in quizItems" :key="index">
              <v-row justify="center">
                <v-card class="rounded-card ma-4 pa-4" outlined--card elevation="8" width="550">
                  <v-card-title class="headline primary--text">
                    Quiz: {{ test.title }}
                  </v-card-title>
                  <v-card-text>
                    Number of questions: {{ test.questions.length }}
                  </v-card-text>
                  <v-row row class="justify-center">
                    <v-btn class="success ma-2" @click="loadTest(test.id)">
                      Show
                    </v-btn>
                    <v-btn class="warning ma-2" v-bind="attrs" @click="editTest(index)" v-on="on">
                      Edit
                    </v-btn>
                    <v-btn class="error ma-2" @click="deleteTest(index)">
                      Delete
                    </v-btn>
                  </v-row>
                </v-card>
              </v-row>
            </v-list-item>
          </v-list>
        </template>
        <v-row justify="center" align="center">
          <validation-observer
            ref="observer"
            v-slot="{ invalid }"
          >
            <v-dialog
              v-model="editDialog"
              transition="dialog-bottom-transition"
              fullscreen
              hide-overlay
            >
              <v-card
                outlined
              >
                <v-toolbar class="primary--text">
                  <v-toolbar-items>
                    <v-btn class="primary--text" @click="closeEdit()">
                      Close
                    </v-btn>
                  </v-toolbar-items>
                  <v-spacer />
                  <v-toolbar-items>
                    <v-btn class="primary--text" :disabled="invalid" @click="onSaveQuiz()">
                      Save
                    </v-btn>
                  </v-toolbar-items>
                </v-toolbar>
                <v-card-text>
                  <v-row
                    align="center"
                    justify="center"
                    class="pa-4"
                  />
                </v-card-text>
                <v-layout wrap justify-center class="ma-2 pa-2">
                  <v-flex xs6 class="ml-3 mr-3">
                    <validation-provider
                      v-slot="{ errors }"
                      name="Quiz title"
                      rules="required|min:3"
                    >
                      <v-text-field
                        v-model="onChangingTest.title"
                        label="Quiz title"
                        required
                        outlined
                        dense
                        :error-messages="errors"
                      />
                    </validation-provider>
                  </v-flex>
                </v-layout>
                <v-layout wrap justify-center>
                  <v-flex v-for="(question, number) in onChangingTest.questions" :key="number" xs12 md6 class="ma-2 pa-2">
                    <v-radio-group v-model="question.correctAnswer">
                      <v-card class="rounded-card pa-8" color="appBar" outlined height="100%">
                        <v-card-title primary-title class="teal--text">
                          Question {{ number + 1 }}
                        </v-card-title>
                        <v-row
                          align="center"
                          justify="center"
                          class="pa-4"
                        >
                          <v-col
                            cols="12"
                            md="12"
                            lg="12"
                            xl="12"
                          >
                            <validation-provider
                              v-slot="{ errors }"
                              :vid="'Question title' + question.id"
                              name="Question title"
                              rules="required|min:5"
                            >
                              <v-text-field
                                v-model="question.title"
                                justify="center"
                                class="ml-3 mr-3"
                                label="Question"
                                required
                                outlined
                                dense
                                :error-messages="errors"
                                append-outer-icon="mdi-delete"
                                @click:append-outer="onDeleteQuestionItem(number)"
                              />
                            </validation-provider>
                          </v-col>
                          <v-btn
                            class="mb-3"
                            @click="onAddAnswer(number)"
                          >
                            Add answer
                          </v-btn>
                        </v-row>
                        <v-card class="mx-auto my-6">
                          <v-col
                            v-for="(answer, i) in question.answers"
                            :key="i"
                            cols="12"
                          >
                            <v-col cols="10">
                              <h3 class="warning--text">
                                Answer {{ i + 1 }}
                              </h3>
                            </v-col>
                            <v-col
                              cols="12"
                              md="12"
                              lg="12"
                              xl="12"
                            >
                              <v-row
                                align="center"
                                justify="center"
                                class="pa-4"
                              >
                                <v-radio class="mb-6" type="radio" :value="answer" @click="setCorrect(question, i)" />
                                <v-col
                                  cols="11"
                                >
                                  <validation-provider
                                    :vid="'Answer title' + answer.id"
                                    v-slot="{ errors }"
                                    name="Answer title"
                                    rules="required"
                                  >
                                    <v-text-field
                                      v-model="answer.answerTitle"
                                      clearable
                                      label="Answer"
                                      required
                                      outlined
                                      dense
                                      :error-messages="errors"
                                      append-outer-icon="mdi-delete"
                                      @click:append-outer="onDeleteAnswerItem(number, i)"
                                    />
                                  </validation-provider>
                                </v-col>
                              </v-row>
                            </v-col>
                          </v-col>
                        </v-card>
                      </v-card>
                      <v-divider />
                    </v-radio-group>
                  </v-flex>
                </v-layout>
                <v-layout class="justify-center align-center text-xs-center">
                  <v-btn large class="orange white--text " @click="onAddQuestion">
                    add question
                  </v-btn>
                </v-layout>
              </v-card>
            </v-dialog>
          </validation-observer>
        </v-row>
      </v-dialog>
    </v-card>
  </v-container>
</template>

<script>

export default {
  data: () => ({
    value: null,
    answer: [{
      correct: false
    }],
    length: 0,
    quizItems: [],
    isLoading: false,
    question: [{
      correctAnswer: []
    }],
    test: [],
    questionItem: [],
    id: null,
    editDialog: false,
    editOnId: -1,
    index: -1,
    errors: null,
    onChangingTest: '',
    answers: [],
    editedQuiz1: {
      title: '',
      questions: [{
        title: null,
        type: 1,
        answers: [
          {
            correct: false,
            title: null
          }
        ]
      }]
    },
    quizzes: {
      editedQuiz: {
        title: '',
        questions: [{
          title: null,
          type: 1,
          answers: [
            {
              correct: false,
              title: null
            }
          ]
        }]
      }
    },
    editedAnswer: {
      title: null,
      correct: null
    }
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
        const { data } = await this.$axios.$get('quiz')
        console.log(data)
        if (data !== null) {
          this.quizItems = data
        }
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    async onDeleteQuestionItem (number) {
      this.questionItem = this.onChangingTest.questions[number]
      if (this.questionItem.id !== undefined) {
        try {
          await this.$axios.$delete('question/' + this.questionItem.id)
          this.onChangingTest.questions.splice(number, 1)
          await this.getQuizzes()
          this.isLoading = false
        } catch (e) {
          this.isLoading = false
        }
      } else {
        this.onChangingTest.questions.splice(number, 1)
      }
    },
    async onDeleteAnswerItem (number, i) {
      this.questionItem = this.onChangingTest.questions[number]
      this.deleleAnswerItems = this.questionItem.answers
      if (this.deleleAnswerItems[i].id !== undefined) {
        try {
          await this.$axios.$delete('answer/' + this.deleleAnswerItems[i].id)
          this.deleleAnswerItems.splice(i, 1)
          this.isLoading = false
        } catch (e) {
          this.isLoading = false
        }
      } else {
        this.deleleAnswerItems.splice(i, 1)
      }
    },
    onAddAnswer (number) {
      this.questionItem = this.onChangingTest.questions[number]
      this.questionItem.answers.push({
        title: null,
        correct: 0
      })
    },
    onAddQuestion () {
      this.onChangingTest.questions.push({
        title: null,
        type: 1,
        answers: [
          {
            correct: false,
            title: null
          }
        ]
      })
    },
    onAddQuiz () {
      this.onChangingTest = this.editedQuiz1
      this.editDialog = true
      console.log(this.editDialog)
    },
    setCorrect (question, index) {
      for (let i = 0; i < question.answers.length; i++) {
        question.answers[i].correct = false
      }
      question.answers[index].correct = true
    },
    async deleteTest (index) {
      if (this.quizItems[index].id !== undefined) {
        try {
          await this.$axios.$delete('quiz/' + this.quizItems[index].id, this.onChangingTest)
          this.quizItems.splice(index, 1)
          this.isLoading = false
        } catch (e) {
          this.isLoading = false
        }
      } else { this.quizItems.splice(index, 1) }
    },
    closeEdit () {
      this.editDialog = false
      this.editOnId = -1
      this.onChangingTest = ''
      this.getQuizzes()
    },
    editTest (index) {
      this.onChangingTest = this.quizItems[index]
      this.editDialog = true
      this.editOnId = index
    },
    async onSaveQuiz () {
      this.isLoading = true
      if (this.onChangingTest.id !== undefined) {
        try {
          await this.$axios.$put('quiz/' + this.onChangingTest.id, this.onChangingTest)
          await this.getQuizzes()
          this.isLoading = false
          this.editDialog = false
        } catch (e) {
          this.isLoading = false
        }
      } else {
        try {
          await this.$axios.$post('quiz', this.onChangingTest)
          this.isLoading = false
          this.editDialog = false
          await this.getQuizzes()
        } catch (e) {
          this.isLoading = false
        }
      }
    },
    loadTest (quizId) {
      this.$router.push({ name: 'takequiz-id', params: { id: quizId } })
    }
  }
}
</script>
