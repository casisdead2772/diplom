<template>
  <v-alert
    :value="show"
    :color="color"
    :type="type"
    :dismissible="dismissible"
  >
    {{ text }}
  </v-alert>
</template>

<script>
export default {
  name: 'Alert',
  props: {
    state: {
      required: true,
      type: Boolean,
      default: false
    },
    color: {
      type: String,
      default: 'green'
    },
    type: {
      type: String,
      default: 'success'
    },
    text: {
      type: String,
      default: 'text'
    },
    dismissible: {
      type: Boolean,
      default: false
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
  mounted () {
    setTimeout(this.onHideAlert, 5000)
  },
  methods: {
    onHideAlert () {
      this.show = false
    }
  }
}
</script>

<style scoped>

</style>
