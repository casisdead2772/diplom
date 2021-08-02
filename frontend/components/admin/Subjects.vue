<template>
  <v-card
    outlined
    class="mx-auto"
  >
    <v-data-table
      :headers="headers"
      :items="subjectItems"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>Subjects</v-toolbar-title>
          <v-spacer />
          <v-dialog
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                New Item
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">New subject</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        v-model="newSubject.name"
                        label="Subject Name"
                      />
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        v-model="newSubject.code"
                        label="Subject code"
                      />
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer />
                <v-btn
                  color="blue darken-1"
                  text
                  @click="close"
                >
                  Cancel
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="onSave"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <v-dialog v-model="createDialog">
        <v-list>
          <v-list-item>
            <v-row justify="center">
              <v-card class="rounded-card ma-4 pa-4" elevation="8" width="550">
                <v-card-title class="headline primary--text">
                  New Subject
                </v-card-title>
                <v-card-text>
                  <validation-provider
                    v-slot="{ errors }"
                    name="Quiz title"
                    rules="required|min:3"
                  >
                    <v-text-field
                      v-model="newSubject.name"
                      label="Subject Name"
                      required
                      outlined
                      dense
                      :error-messages="errors"
                    />
                  </validation-provider>
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
      </v-dialog>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  name: 'Subjects',
  data: () => ({
    subjectItems: [],
    newSubject: {
      name: '',
      code: ''
    },
    defaultSubject: {
      name: '',
      code: ''
    },
    createDialog: false,
    id: null,
    isLoading: false,
    headers: [
      { text: 'Id', sortable: false, value: 'id' },
      { text: 'Subject name', sortable: false, value: 'name' },
      { text: 'Code', sortable: false, value: 'code' }
    ],
    showLessonDialog: false,
    isLoadingDialog: false,
    agreeLesson: -1,
    selectedLesson: null
  }),
  watch: {
    options: {
      handler () {
        this.getSubjects()
      },
      deep: true
    }
  },
  created () {
    this.getSubjects()
  },
  methods: {
    async getSubjects () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('subjects')
        this.subjectItems = data
        console.log(this.subjectItems)
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    async onSave () {
      this.isLoading = true
      try {
        await this.$axios.$post('subject-add', this.newSubject)
        this.dialog = false
        this.newSubject = this.defaultSubject
        await this.getSubjects()
        this.isLoading = false
        this.editDialog = false
      } catch (e) {
        this.isLoading = false
      }
    },
    close () {
      this.dialog = false
      this.newSubject = this.defaultSubject
    }
  }
}
</script>

<style scoped>

</style>
