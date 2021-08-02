<template>
  <v-img
    :src="require('@/assets/logo2.jpg')"
    :min-height="minHeight"
  >
    <v-responsive
      class="align-center mx-auto"
      max-width="500"
      width="100%"
      min-height="500"
    >
      <base-heading
        weight="regular"
        title="Get knowledge"
        size="text-h3"
      />

      <base-subheading
        third
        size="text-h4"
        title="Welcome to 4Teaching"
        weight="medium"
      />
    </v-responsive>
  </v-img>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Dashboard',
  middleware: ['auth', 'teacher'],
  computed: {
    ...mapGetters(['loggedInUser', 'isAuthenticated']),
    minHeight () {
      const height = this.$vuetify.breakpoint.mdAndUp ? '100vh' : '50vh'
      return `calc(${height} - ${this.$vuetify.application.top}px)`
    }
  }
}
</script>
