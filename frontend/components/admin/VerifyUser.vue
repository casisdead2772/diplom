<template>
  <v-card
    outlined
    class="mx-auto"
  >
    <v-data-table
      :headers="headers"
      :items="userItems"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>New teachers</v-toolbar-title>
        </v-toolbar>
      </template>
      <template
        v-slot:item.actions="item"
      >
        <v-btn
          small
          class="mr-2"
          color="success"
          @click="onVerifyUser(item)"
        >
          Verify this User
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
        3: 'Canceled'
      }
      return statusMap[status]
    }
  },
  data: () => ({
    userItems: [],
    id: null,
    isLoading: false,
    headers: [
      { text: 'Id', sortable: false, value: 'id' },
      { text: 'E-mail', sortable: false, value: 'email' },
      { text: 'Name', sortable: false, value: 'userInformation.firstName' },
      { text: 'Last name', value: 'userInformation.lastName' },
      { text: 'Actions', value: 'actions', sortable: false }
    ],
    showLessonDialog: false,
    isLoadingDialog: false,
    agreeLesson: -1,
    selectedLesson: null
  }),
  computed: {
    hasErrors () {
      return this.errorMessages !== null
    },
    dialogTitle () {
      return this.agreeLesson === -1 ? 'Verify User' : 'Not Verify User'
    },
    dialogTxt () {
      return 'Yes'
    },
    dialogHintTxt () {
      return this.agreeLesson === -1 ? 'Are you sure start verify user?' : 'Are you sure Not Verify User?'
    },
    teacherRole () {
      return TEACHER_ROLE_NAME
    }
  },
  watch: {
    options: {
      handler () {
        this.getUsers()
      },
      deep: true
    }
  },
  created () {
    this.getUsers()
  },
  methods: {
    checkPermission,
    async getUsers () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('teachers-list')
        if (data != null) {
          this.userItems = data
          this.isLoading = false
        }
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
    async onVerifyUser (data) {
      this.selectedUser = data.item.id
      this.isLoadingDialog = true
      try {
        await this.$axios.$put('user-verified/' + this.selectedUser)
        await this.getUsers()
      } catch (err) {
        this.setDefault()
        await this.getUsers()
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
