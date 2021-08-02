<template>
  <div class="text-center">
    <v-snackbar
      v-model="show"
      top
    >
      {{ message }}
      <template v-slot:action="{ attrs }">
        <v-btn
          :color="color"
          text
          v-bind="attrs"
          @click="close"
        >
          {{ btnTxt }}
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  name: 'Notification',
  props: {
    state: {
      type: Boolean,
      default: false
    },
    message: {
      type: String,
      default: 'Some text'
    },
    color: {
      type: String,
      default: 'primary'
    },
    btnTxt: {
      type: String,
      default: 'Close'
    }
  },
  computed: {
    show: {
      get () {
        return this.state
      },
      set (value) {
        if (!value) {
          this.$emit('close')
        }
      }
    }
  },
  methods: {
    close () {
      this.show = false
    }
  }
}
</script>

<style scoped>

</style>
