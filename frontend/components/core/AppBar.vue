<template>
  <v-app-bar
    :clipped-left="$vuetify.breakpoint.lgAndUp"
    :clipped-right="$vuetify.breakpoint.lgAndUp"
    app
    fixed
    elevation="0"
    color="appBar"
  >
    <!--
      For guest drawer
    -->
    <v-app-bar-nav-icon
      v-if="$store.state.auth.user && hasTeacherInfo"
      @click.stop="$emit('toggle')"
    />

    <v-toolbar-title class="ml-0 pl-4  align-center" style="width: 200px">
      <NuxtLink
        :to="$store.state.auth.user ? `/dashboard`: `/`"
      >
        <span class="hidden-sm-and-down linkApp">4Teaching</span>
      </NuxtLink>
    </v-toolbar-title>
    <client-only>
      <v-row v-if="$vuetify.breakpoint.lgAndUp">
        <v-col
          class="text-center mb-sm-0 mb-5"
          cols="auto"
        >
          <NuxtLink
            v-if="$store.state.auth.user && !checkPermission(['teacher'])"
            to="/tutors"
            class="px-3 linkApp"
          >
            <span class="hidden-sm-and-down">
              Find Tutor
            </span>
          </NuxtLink>
          <NuxtLink
            v-if="$store.state.auth.user && !checkPermission(['teacher'])"
            to="/about"
            class="px-3 linkApp"
            v-text="`Become a tutor`"
          />
          <NuxtLink
            v-if="!$store.state.auth.user"
            to="/sign-up-tutor"
            class="px-3 linkApp"
            v-text="`Become a tutor`"
          />
        </v-col>
      </v-row>
    </client-only>
    <v-spacer />
    <div>
      <NuxtLink
        v-if="!$store.state.auth.user"
        to="/sign-in"
        class="linkApp"
        v-text="`Log in`"
      />
    </div>
    <div class="pr-3">
      <v-menu v-if="$store.state.auth.user" offset-y>
        <template v-slot:activator="{ on }">
          <v-btn icon small v-on="on">
            <v-icon>mdi-account-circle</v-icon>
          </v-btn>
        </template>

        <v-list nav dense>
          <template v-if="getName">
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="title">
                  {{ getName }}
                </v-list-item-title>
                <v-list-item-subtitle v-if="getEmail">
                  {{ getEmail }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider />
          </template>
          <v-list-item
            v-for="(item, index) in profileMenu"
            :key="index"
            link
            :to="item.link"
            class="mt-2"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item
            @click.stop="dialogLogout = true"
          >
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Logout</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-menu>
      <logout
        :dialog="dialogLogout"
        @close="dialogLogout = false"
      />
    </div>
    <v-divider
      vertical
      inset
    />
    <div class="pl-3">
      <v-btn
        icon
        small
        @click.native="$vuetify.theme.dark = !$vuetify.theme.dark"
      >
        <v-icon>{{ themeIcon }}</v-icon>
      </v-btn>
    </div>
  </v-app-bar>
</template>

<script>

import checkPermission from '@/utils/permission'

export default {
  name: 'AppBar',
  components: {
    Logout: () => import('@/components/logout/Logout')
  },
  props: {
    /**
     * Profile related links, visible inside authenticated dropdown menu.
     */
    profileMenu: {
      type: Array,
      default: () => []
    },
    /**
     * Disable create menu.
     */
    disableCreate: Boolean,
    /**
     * Disable reload state button.
     */
    disableReload: Boolean
  },
  data: () => ({
    dialogLogout: false
  }),
  computed: {
    getName () {
      return this.$store.getters.loggedInUser.first_name
    },
    getEmail () {
      return this.$store.getters.loggedInUser.email
    },
    hasTeacherInfo () {
      return this.$store.state.auth.user.teacher_info !== null
    },
    themeIcon () {
      return this.$vuetify.theme.dark ? 'mdi-brightness-4' : 'mdi-brightness-5'
    }
  },
  methods: {
    checkPermission
  }
}
</script>

<style scoped>
</style>
