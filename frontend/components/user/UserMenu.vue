<template>
  <v-menu
    v-if="loggedInUser"
    offset-y
  >
    <template v-slot:activator="{ on }">
      <v-btn icon small class="ml-5" v-on="on">
        <v-icon>mdi-account-box</v-icon>
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
      <v-list-item @click="logout">
        <v-list-item-icon>
          <v-icon>mdi-logout</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'UserMenu',
  data: () => ({
    profileMenu: [
      {
        icon: 'mdi-account',
        text: 'profile',
        link: '/profile'
      }
    ]
  }),
  computed: {
    getName () {
      return this.loggedInUser.email
    },
    getEmail () {
      return this.loggedInUser.email
    },
    ...mapGetters(['loggedInUser', 'isAuthenticated'])
  }
}
</script>

<style scoped>

</style>
