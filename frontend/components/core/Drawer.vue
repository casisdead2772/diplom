<template>
  <v-navigation-drawer
    :clipped="$vuetify.breakpoint.lgAndUp"
    app
    fixed
    color="navigation"
    :mini-variant="miniVariant"
    :value="value"
    @input="(v) => $emit('input', v)"
  >
    <template v-slot:img="props">
      <!-- @slot Image background. -->
      <slot name="img" v-bind="props" />
    </template>
    <v-list dense>
      <v-list-item link to="/dashboard">
        <v-list-item-action>
          <v-icon>mdi-view-dashboard-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Dashboard
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider />
      <template v-if="checkPermission(['teacher'])">
        <v-subheader v-if="!miniVariant">
          Requests
        </v-subheader>
        <!--        <v-list-item-->
        <!--          link-->
        <!--          to="/classes"-->
        <!--        >-->
        <!--          <v-list-item-action>-->
        <!--            <v-icon>mdi-school-outline</v-icon>-->
        <!--          </v-list-item-action>-->
        <!--          <v-list-item-content>-->
        <!--            <v-list-item-title>-->
        <!--              Classes-->
        <!--            </v-list-item-title>-->
        <!--          </v-list-item-content>-->
        <!--        </v-list-item>-->
        <!--        <v-list-item-->
        <!--          link-->
        <!--          to="/students"-->
        <!--        >-->
        <!--          <v-list-item-action>-->
        <!--            <v-icon>mdi-account-group-outline</v-icon>-->
        <!--          </v-list-item-action>-->
        <!--          <v-list-item-content>-->
        <!--            <v-list-item-title>-->
        <!--              Students-->
        <!--            </v-list-item-title>-->
        <!--          </v-list-item-content>-->
        <!--        </v-list-item>-->
        <v-list-item
          link
          to="/requests"
        >
          <v-list-item-action>
            <v-icon>mdi-message-flash-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-badge
              v-if="hasReservedLessons"
              color="primary"
              overlap
              offset-x="0"
              offset-y="7"
              inline
              :content="reservedLessonsCount"
            >
              <v-list-item-title>
                Requests
              </v-list-item-title>
            </v-badge>
            <v-list-item-title v-else>
              Requests
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <!--        <v-list-item-->
        <!--          link-->
        <!--          to="/schedule"-->
        <!--        >-->
        <!--          <v-list-item-action>-->
        <!--            <v-icon>mdi-calendar-blank-outline</v-icon>-->
        <!--          </v-list-item-action>-->
        <!--          <v-list-item-content>-->
        <!--            <v-list-item-title>-->
        <!--              Schedule-->
        <!--            </v-list-item-title>-->
        <!--          </v-list-item-content>-->
        <!--        </v-list-item>-->
        <!--        <v-list-item-->
        <!--          link-->
        <!--          to="/my-library"-->
        <!--        >-->
        <!--          <v-list-item-action>-->
        <!--            <v-icon>mdi-pencil-box-multiple-outline</v-icon>-->
        <!--          </v-list-item-action>-->
        <!--          <v-list-item-content>-->
        <!--            <v-list-item-title>-->
        <!--              My library-->
        <!--            </v-list-item-title>-->
        <!--          </v-list-item-content>-->
        <!--        </v-list-item>-->
        <v-divider />
      </template>
      <v-subheader v-if="!miniVariant">
        Lessons
      </v-subheader>
      <v-list-item
        link
        to="/lessons"
      >
        <v-list-item-action>
          <v-icon>mdi-book-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Lessons
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider />
      <v-subheader v-if="!miniVariant">
        Other
      </v-subheader>
      <v-list-item
        v-if="checkPermission(['teacher'])"
        link
        to="/quizzes"
      >
        <v-list-item-action>
          <v-icon>mdi-book-open-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Quizzes
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        v-if="!checkPermission(['teacher'])"
        link
        to="/user-quizzes"
      >
        <v-list-item-action>
          <v-icon>mdi-book-open-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Quizzes
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        v-if="checkPermission(['teacher'])"
        link
        to="/about"
      >
        <v-list-item-action>
          <v-icon>mdi-cog-outline</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Settings
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-subheader v-if="!miniVariant && checkPermission(['admin'])">
        Admin Panel
      </v-subheader>
      <v-list-item
        v-if="checkPermission(['admin'])"
        link
        to="/verify-users"
      >
        <v-list-item-action>
          <v-icon>mdi-account</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Verify users
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item
        v-if="checkPermission(['admin'])"
        link
        to="/subject"
      >
        <v-list-item-action>
          <v-icon>mdi-book</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>
            Subjects
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
    <br>
  </v-navigation-drawer>
</template>

<script>
import checkPermission from '@/utils/permission'

export default {
  name: 'Drawer',
  props: {
    /**
     * Minimize the sidebar and show only icons.
     */
    miniVariant: Boolean,
    /**
     * Control visibility
     */
    value: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    reservedLessonsCount () {
      return this.$store.state.base.reservedLessonsCount
    },
    hasReservedLessons () {
      return parseInt(this.$store.state.base.reservedLessonsCount) !== 0
    }
  },
  methods: {
    checkPermission
  }
}
</script>
