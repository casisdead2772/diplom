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
          <v-toolbar-title>Lesson requests</v-toolbar-title>
        </v-toolbar>
      </template>
      <template v-slot:item.reserved_time="{ item }">
        {{ $moment.unix(item.reserved_time - (60 * 3 * 60)).format("DD/MM/YYYY H:mm") }}
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
          v-if="isNewReserve(item)"
          small
          class="mr-2"
          color="success"
          @click="onAccept(item)"
        >
          mdi-check
        </v-icon>
        <v-icon
          v-if="isNewReserve(item)"
          small
          color="red"
          @click="onCancel(item)"
        >
          mdi-close
        </v-icon>
      </template>
    </v-data-table>
    <simple-dialog
      :dialog="showLessonDialog"
      :btn-agree-txt="dialogTxt"
      :btn-cancel-txt="`Back`"
      :is-loading="isLoadingDialog"
      :title="dialogTitle"
      :hint="dialogHintTxt"
      :callback="callbackLesson"
      @close="onCloseDialog"
    />
  </v-card>
</template>

<script>

import { mapActions } from 'vuex'
import { STATUS_RESERVE_LESSON_NEW, STATUS_RESERVE_LESSON_APPROVED, STATUS_RESERVE_LESSON_CANCEL } from '@/utils/constants'

export default {
  name: 'ReservedLessons',
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
    lessonItems: [],
    id: null,
    isLoading: false,
    headers: [
      { text: 'Id', sortable: false, value: 'id' },
      { text: 'Name', sortable: false, value: 'first_name' },
      { text: 'Last name', value: 'last_name' },
      { text: 'Day', value: 'reserved_time' },
      { text: 'Status', value: 'status' },
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
      return this.agreeLesson === -1 ? 'Approve lesson' : 'Cancel lesson'
    },
    dialogTxt () {
      return this.agreeLesson === -1 ? 'Approve' : 'Cancel'
    },
    dialogHintTxt () {
      return this.agreeLesson === -1 ? 'Are you sure approve lesson?' : 'Are you sure cancel lesson?'
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
    ...mapActions({
      getReservedLessonsCount: 'base/fetchReservedLessonsCount'
    }),
    async getLessons () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('reserve-lesson')
        console.log(data)
        this.lessonItems = data.data
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    getStatusColor (value) {
      if (value === STATUS_RESERVE_LESSON_NEW) {
        return 'teal'
      }
      if (value === STATUS_RESERVE_LESSON_APPROVED) {
        return 'green'
      }
      if (value === STATUS_RESERVE_LESSON_CANCEL) {
        return 'red'
      }
    },
    onAccept (data) {
      this.showLessonDialog = true
      this.selectedLesson = data.item
    },
    onCancel (data) {
      this.showLessonDialog = true
      this.selectedLesson = data.item
      this.agreeLesson = 0
    },
    async onAcceptLesson () {
      this.isLoadingDialog = true
      try {
        const { success } = await this.$axios.$patch('reserve-lesson/' + this.selectedLesson.id)
        if (success) {
          this.isLoadingDialog = false
          await this.getLessons()
          await this.getReservedLessonsCount()
        }
        this.setDefault()
      } catch (err) {
        this.setDefault()
      }
    },
    async onCancelLesson () {
      this.isLoadingDialog = true
      try {
        await this.$axios.$delete('reserve-lesson/' + this.selectedLesson.id)
        await this.getLessons()
        await this.getReservedLessonsCount()
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
    isNewReserve (item) {
      return item.item.status === STATUS_RESERVE_LESSON_NEW
    },
    setDefault () {
      this.isLoadingDialog = false
      this.showLessonDialog = false
      this.agreeLesson = -1
    }
  }
}
</script>
