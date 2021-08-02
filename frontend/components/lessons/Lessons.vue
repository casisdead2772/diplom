<template>
  <v-card
    outlined
    class="mx-auto"
  >
    <v-data-table
      :headers="headers"
      :items="lessonItems"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>Lesson</v-toolbar-title>
        </v-toolbar>
      </template>
      <template v-slot:item.lesson_time="{ item }">
        {{ $moment.unix(item.lesson_time - (60 * 3 * 60)).format("DD/MM/YYYY H:mm") }}
      </template>
      <template v-slot:item.status="{ item }">
        <v-chip
          small
          :color="getStatusColor(item.status)"
          dark
        >
          {{ item.status | statusFilter }}
        </v-chip>
      </template>
      <template
        v-slot:item.actions="item"
      >
        <v-icon
          v-if="isNewLesson(item) && checkPermission([teacherRole])"
          small
          class="mr-2"
          color="success"
          @click="onStartLesson(item)"
        >
          mdi-play
        </v-icon>
        <v-icon
          v-if="isNewLesson(item) && checkPermission([teacherRole])"
          small
          color="red"
          @click="onCancel(item)"
        >
          mdi-close
        </v-icon>
        <v-btn
          v-if="isStartedLesson(item)"
          @click="onJoinMeeting(item)"
        >
          Join
        </v-btn>
        <v-btn
          v-if="isStartedLesson(item) && checkPermission([teacherRole])"
          @click="onCompletedMeeting(item)"
        >
          Completed
        </v-btn>
      </template>
    </v-data-table>
    <simple-dialog
      :dialog="showLessonDialog"
      :btn-agree-txt="dialogTxt"
      :btn-cancel-txt="`Cancel`"
      :is-loading="isLoadingDialog"
      :title="dialogTitle"
      :hint="dialogHintTxt"
      :callback="callbackLesson"
      @close="onCloseDialog"
    />
  </v-card>
</template>

<script>

import {
  STATUS_LESSON_NEW,
  STATUS_LESSON_STARTED,
  STATUS_LESSON_COMPLETED,
  STATUS_LESSON_MISSED,
  STATUS_LESSON_CANCEL,
  TEACHER_ROLE_NAME
} from '@/utils/constants'

import checkPermission from '../../utils/permission'

export default {
  name: 'Lessons',
  components: {
    SimpleDialog: () => import('@/components/base/Dialog')
  },
  filters: {
    statusFilter (status) {
      const statusMap = {
        1: 'New',
        2: 'Accepted',
        3: 'Completed',
        4: 'Missed',
        5: 'Canceled'
      }
      return statusMap[status]
    }
  },
  data: () => ({
    lessonItems: [],
    id: null,
    isLoading: false,
    headers: [
      { text: 'Id', sortable: false, value: 'id' },
      { text: 'Subject', sortable: false, value: 'subject_name' },
      { text: 'Name', sortable: false, value: 'first_name' },
      { text: 'Last name', value: 'last_name' },
      { text: 'Day', value: 'lesson_time' },
      { text: 'Status', value: 'status' },
      { text: 'Actions', value: 'actions', sortable: false }
    ],
    showLessonDialog: false,
    isLoadingDialog: false,
    agreeLesson: -1,
    selectedLesson: null
  }),
  computed: {
    localeDate (item) {
      return (new Date(this.item)).toLocaleDateString()
    },
    hasErrors () {
      return this.errorMessages !== null
    },
    dialogTitle () {
      return this.agreeLesson === -1 ? 'Start lesson' : 'Cancel lesson'
    },
    dialogTxt () {
      return 'Yes'
    },
    dialogHintTxt () {
      return this.agreeLesson === -1 ? 'Are you sure start lesson?' : 'Are you sure cancel lesson?'
    },
    teacherRole () {
      return TEACHER_ROLE_NAME
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
    checkPermission,
    methods: {
      formatDate: d => d.toLocaleString('ru-RU').replace(',', '').slice(0, -3)
    },
    async getLessons () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('lesson')
        console.log(data)
        this.lessonItems = data.data
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    getStatusColor (value) {
      if (value === STATUS_LESSON_NEW) {
        return 'teal'
      }
      if (value === STATUS_LESSON_STARTED) {
        return 'orange'
      }
      if (value === STATUS_LESSON_COMPLETED) {
        return 'green'
      }
      if (value === STATUS_LESSON_MISSED) {
        return 'grey'
      }
      if (value === STATUS_LESSON_CANCEL) {
        return 'red'
      }
    },
    onStart (data) {
      this.showLessonDialog = true
      this.selectedLesson = data.item
    },
    onCancel (data) {
      this.showLessonDialog = true
      this.selectedLesson = data.item
      this.agreeLesson = 0
    },
    async onStartLesson (data) {
      this.selectedLesson = data.item.id
      this.isLoadingDialog = true
      try {
        await this.$axios.$post('lesson', { lesson_id: this.selectedLesson })
        await this.getLessons()
      } catch (err) {
        this.setDefault()
        await this.getLessons()
      }
    },
    async onJoinMeeting (data) {
      this.selectedLesson = data.item.id
      this.isLoadingDialog = true
      try {
        const { data } = await this.$axios.$get('lesson/' + this.selectedLesson)
        window.open(data)
      } catch (err) {
        this.setDefault()
      }
    },
    async onCompletedMeeting (data) {
      this.selectedLesson = data.item.id
      this.isLoadingDialog = true
      try {
        await this.$axios.$put('lesson/' + this.selectedLesson)
        await this.getLessons()
        this.setDefault()
      } catch (err) {
        this.setDefault()
      }
    },
    async onCancelLesson () {
      this.isLoadingDialog = true
      try {
        await this.$axios.$delete('lesson/' + this.selectedLesson.id)
        await this.getLessons()
        this.setDefault()
      } catch (err) {
        this.setDefault()
      }
    },
    callbackLesson () {
      return this.agreeLesson === -1 ? this.onAcceptLesson() : this.onCancelLesson()
    },
    onCloseDialog () {
      this.setDefault()
    },
    isNewLesson (item) {
      return item.item.status === STATUS_LESSON_NEW
    },
    isStartedLesson (item) {
      return item.item.status === STATUS_LESSON_STARTED
    },
    setDefault () {
      this.isLoadingDialog = false
      this.showLessonDialog = false
      this.agreeLesson = -1
    }
  }
}
</script>

<style scoped>

</style>
