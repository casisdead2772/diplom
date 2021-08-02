<template>
  <v-container>
    <v-alert
      v-if="noUserInfo || noTeacherInfo"
      dense
      class="mx-auto"
      max-width="830"
      type="warning"
    >
      You must prepare your teacher profile information for next step.
    </v-alert>
    <information />
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'About',
  components: {
    Information: () => import('@/components/teacher/Information')
  },
  middleware: ['auth'],
  computed: {
    noUserInfo () {
      return this.$store.state.auth.user.user_info === null
    },
    noTeacherInfo () {
      return this.$store.state.auth.user.teacher_info === null
    }
  },
  created () {
    this.getCountries()
    this.getSubjects()
    this.getLanguages()
    this.getLanguageGrades()
  },
  methods: {
    ...mapActions({
      getCountries: 'base/fetchCountries',
      getSubjects: 'base/fetchSubjects',
      getLanguages: 'base/fetchLanguages',
      getLanguageGrades: 'base/fetchLanguageGrades'
    })
  }
}
</script>

<style scoped>

</style>
