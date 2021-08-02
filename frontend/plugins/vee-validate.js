import Vue from 'vue'
import { ValidationObserver, ValidationProvider, extend, setInteractionMode } from 'vee-validate/dist/vee-validate.full'

setInteractionMode('eager')

extend('password', {
  params: ['target'],
  validate (value, { target }) {
    return value === target
  },
  message: 'Password confirmation does not match'
})

Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)
