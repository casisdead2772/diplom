<template>
  <v-app dark>
    <core-drawer
      v-if="$store.state.auth.user && hasTeacherInfo"
      v-model="drawer"
      :mini-variant="mini"
    />
    <core-app-bar
      :profile-menu="profileMenu"
      color="secondary"
      dense
      @toggle="$vuetify.breakpoint.lgAndUp ? (mini = !mini) : (drawer = !drawer)"
    />
    <core-view />
    <core-footer v-if="!$store.state.auth.user" />
  </v-app>
</template>

<script>

import { mapActions, mapGetters } from 'vuex'
import { TEACHER_ROLE_NAME } from '@/utils/constants'

export default {
  components: {
    CoreAppBar: () => import('~/components/core/AppBar'),
    CoreView: () => import('~/components/core/View'),
    CoreDrawer: () => import('~/components/core/Drawer'),
    CoreFooter: () => import('~/components/core/Footer')
  },
  data: () => ({
    drawer: null,
    mini: false,
    profileMenu: [
      {
        icon: 'mdi-account',
        text: 'profile',
        link: '/profile'
      }
    ]
  }),
  computed: {
    ...mapGetters(['loggedInUser', 'isAuthenticated']),
    isTeacher () {
      return this.loggedInUser.roles.includes(TEACHER_ROLE_NAME)
    },
    hasTeacherInfo () {
      return this.loggedInUser.teacher_info !== null && this.loggedInUser.user_info !== null
    }
  },
  created () {
    this.getCountries()
    this.getSubjects()
    this.getLanguages()
    this.getLanguageGrades()
    if (this.isAuthenticated && this.isTeacher) {
      this.getReservedLessonsCount()
    }
  },
  methods: {
    ...mapActions({
      getCountries: 'base/fetchCountries',
      getSubjects: 'base/fetchSubjects',
      getLanguages: 'base/fetchLanguages',
      getLanguageGrades: 'base/fetchLanguageGrades',
      getReservedLessonsCount: 'base/fetchReservedLessonsCount'
    })
  }
}
</script>

<style>
.theme--light .v-main {
  background: #ececec !important;
}

.theme--dark .v-main {
  background: #121212 !important;
}

a {
  color: #384047;
  text-decoration: none;
}

a:hover {
  color: #0f7367;
}

a:link {
  color: #384047;
  background-color: transparent;
  text-decoration: none;
}

.capitalized-btn::first-letter {
  text-transform: lowercase;
}

.capitalized-btn::first-letter {
  text-transform: uppercase !important;
}

/* APP LINK */
.theme--dark .linkApp {
  font-size: 0.825rem;
  font-weight: 500;
  text-decoration: none;
  text-transform: uppercase;
  color: #ffffff;
}

.theme--light .linkApp {
  font-size: 0.825rem;
  font-weight: 500;
  text-decoration: none;
  text-transform: uppercase;
  color: black;
}

.linkApp:hover {
  color: #16C5AD;
}

/* OTHER LINK */
.theme--dark .links {
  font-size: 14px;
  color: #ffffff;
  font-weight: 400
}

.links:hover {
  color: #16C5AD;
}

.theme--light .links {
  font-size: 14px;
  color: black;
  font-weight: 400
}

.theme--light .links:hover {
  color: #16C5AD;
}

.social-btn {
  width: 196px;
}
</style>
