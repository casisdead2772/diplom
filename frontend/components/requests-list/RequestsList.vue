<template>
  <v-container>
    <v-card
      outlined
      tile
      class="mx-auto"
      max-width="700"
    >
      <v-data-table
        :headers="headers"
        :items="lessons"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar
            flat
          >
            <v-toolbar-title>Your lesson requests</v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            />
            <v-spacer />
          </v-toolbar>
        </template>
        <template v-slot:item.actions="item">
          <v-icon
            small
            class="mr-2"
            @click="AcceptLesson(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="CancelLesson(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: 'Lessons',
  data: () => ({
    lessons: [],
    form: {
      status: null
    },
    id: null,
    isLoading: false,
    headers: [
      { text: 'Name', align: 'center', sortable: false, value: 'first_name' },
      { text: 'Lastname', value: 'last_name' },
      { text: 'Day', value: 'created_at.date', align: 'center' },
      { text: 'Status', value: 'status', align: 'center' },
      { text: 'Change status lesson', value: 'actions', align: 'center' }
    ]
  }),
  computed: {
    hasErrors () {
      return this.errorMessages !== null
    },
    isSaving () {
      return false
    }
  },
  watch: {
    options: {
      handler () {
        this.getLessons()
      },
      deep: true
    }
  },
  created () {
    this.getLessons()
  },
  methods: {
    async AcceptLesson (item) {
      this.isLoading = true
      try {
        this.id = item.item.id
        this.form.status = '2'
        await this.$axios.$put('reserve-lesson/' + this.id, this.form)
        this.isLoading = false
      } catch (err) {
        this.isLoading = false
      }
    },
    async CancelLesson (item) {
      this.isLoading = true
      try {
        this.id = item.item.id
        this.form.status = '3'
        await this.$axios.$put('reserve-lesson/' + this.id, this.form)
        this.isLoading = false
      } catch (err) {
        this.isLoading = false
      }
    },
    async getLessons () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('reserve-lesson')
        this.lessons = data.data
      } catch (e) {
        this.isLoading = false
      }
    }
  }
}

</script>

<style scoped>

</style>
