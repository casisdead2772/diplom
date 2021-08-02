<template>
  <v-dialog
    v-model="show"
    persistent
    max-width="290"
  >
    <v-card>
      <v-card-title class="headline">
        Logout
      </v-card-title>
      <v-card-text>Are you sure you want to exit?</v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn
          text
          :disabled="isLoadingLogout"
          @click="show = false"
        >
          Cancel
        </v-btn>
        <v-btn
          color="primary"
          text
          :loading="isLoadingLogout"
          @click="onLogOut"
        >
          Exit
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'Logout',
  props: {
    dialog: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    isLoadingLogout: false
  }),
  computed: {
    show: {
      get () {
        return this.dialog
      },
      set (value) {
        if (!value) {
          this.$emit('close')
        }
      }
    }
  },
  methods: {
    async onLogOut () {
      this.isLoadingLogout = true
      try {
        await this.$auth.logout()
        this.isLoadingLogout = false
        this.show = false
      } catch (e) {
        this.isLoadingLogout = false
        this.show = false
        throw new Error(e)
      } finally {
        this.isLoadingLogout = false
        this.show = false
      }
    }
  }
}
</script>
