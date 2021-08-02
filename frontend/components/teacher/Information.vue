<template>
  <v-card
    outlined
    tile
    class="mx-auto"
    max-width="830"
  >
    <v-toolbar
      flat
      color="primary"
      dark
    >
      <v-toolbar-title>Teacher Information</v-toolbar-title>
    </v-toolbar>
    <v-tabs vertical>
      <v-tab>
        About
      </v-tab>
      <v-tab-item>
        <about-information />
      </v-tab-item>
    </v-tabs>
  </v-card>
</template>

<script>
export default {
  name: 'Information',
  components: {
    AboutInformation: () => import('@/components/teacher/AboutInformation')
  }
}
</script>

<style scoped>

</style>
