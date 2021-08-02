<template>
  <v-row justify="center">
    <v-dialog
      v-model="show"
      persistent
      :max-width="maxWidth"
    >
      <v-card>
        <v-card-title class="headline">
          {{ title }}
        </v-card-title>
        <v-card-text>{{ hint }}</v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            text
            :disabled="isLoading"
            @click="show = false"
          >
            {{ btnCancelTxt }}
          </v-btn>
          <v-btn
            :color="color"
            text
            :loading="isLoading"
            @click="callback"
          >
            {{ btnAgreeTxt }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: 'Dialog',
  props: {
    dialog: {
      required: true,
      type: Boolean,
      default: false
    },
    btnAgreeTxt: {
      type: String,
      default: 'Agree'
    },
    btnCancelTxt: {
      type: String,
      default: 'Cancel'
    },
    isLoading: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: 'Title'
    },
    maxWidth: {
      type: Number,
      default: 290
    },
    color: {
      type: String,
      default: 'primary'
    },
    hint: {
      type: String,
      default: 'Hint text'
    },
    callback: {
      required: true,
      type: Function,
      default: () => {}
    }
  },
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
  }
}
</script>

<style scoped>

</style>
