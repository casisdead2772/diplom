<template>
  <v-container>
    <profile-settings/>
  </v-container>
</template>

<script>

export default {
  components: {
    ProfileSettings: () => import('@/components/profile/ProfileSettings')
  },
  middleware: 'auth'
}
</script>
