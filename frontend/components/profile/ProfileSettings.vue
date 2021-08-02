<template>
  <v-container>
    <v-row justify="center">
      <v-alert
        v-if="hasErrors"
        type="error"
        max-width="400"
        :message="error"
      >
        Something went wrong
      </v-alert>
    </v-row>
    <validation-observer
      ref="observer"
      v-slot="{ invalid }"
    >
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
          <v-toolbar-title>User Information</v-toolbar-title>
        </v-toolbar>
        <v-tabs vertical>
          <v-tab
            v-if="$store.state.auth.user"
          >
            About
          </v-tab>
          <v-tab-item
            v-if="$store.state.auth.user"
          >
            <v-card-title>About</v-card-title>
            <v-card-text>
              <form @submit.prevent="onSave">
                <validation-provider
                  v-slot="{ errors }"
                  name="First name"
                  rules="required|max:20"
                >
                  <v-text-field
                    v-model="informationForm.first_name"
                    :label="('Name')"
                    required
                    outlined
                    dense
                    :error-messages="errors"
                  />
                </validation-provider>
                <validation-provider
                  v-slot="{ errors }"
                  name="First name"
                  rules="required|max:20"
                >
                  <v-text-field
                    v-model="informationForm.last_name"
                    :label="('Last Name')"
                    required
                    outlined
                    dense
                    :error-messages="errors"
                  />
                </validation-provider>
                <validation-provider
                  v-slot="{ errors }"
                  name="Email"
                  rules="required|email"
                >
                  <v-text-field
                    ref="email"
                    v-model="informationForm.email"
                    :label="('Email')"
                    type="email"
                    required
                    outlined
                    dense
                    :error-messages="errors"
                  />
                </validation-provider>
              </form>
              <v-btn
                color="primary"
                :loading="isLoading"
                depressed
                width="127"
                class="ml-2"
                :disabled="invalid"
                @click="onSave"
              >
                Update info
              </v-btn>
            </v-card-text>
          </v-tab-item>
          <v-tab>
            Email
          </v-tab>
          <v-tab-item>
            <v-card-title>Email</v-card-title>
            <v-card-text>
              <form @submit.prevent="changePassword">
                <v-text-field
                  v-model="passwordForm.current_password"
                  :label="('Current password')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
                <v-text-field
                  v-model="passwordForm.password"
                  :label="('New Password')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
                <v-text-field
                  v-model="passwordForm.password_confirmation"
                  :label="('Password confirmation')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
              </form>
              <v-btn
                color="warning"
                :loading="isSaving"
                depressed
                class="ml-2"
                @click="changePassword"
              >
                Change password
              </v-btn>
            </v-card-text>
          </v-tab-item>
          <v-tab>
            Password
          </v-tab>
          <v-tab-item>
            <v-card-title>Change password</v-card-title>
            <v-card-text>
              <form @submit.prevent="changePassword">
                <v-text-field
                  v-model="passwordForm.current_password"
                  :label="('Current password')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
                <v-text-field
                  v-model="passwordForm.password"
                  :label="('New Password')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
                <v-text-field
                  v-model="passwordForm.password_confirmation"
                  :label="('Password confirmation')"
                  type="password"
                  required
                  outlined
                  dense
                  :error-messages="errors"
                />
              </form>
              <v-btn
                color="warning"
                :loading="isSaving"
                depressed
                class="ml-2"
                @click="changePassword"
              >
                Change password
              </v-btn>
            </v-card-text>
          </v-tab-item>
        </v-tabs>
      </v-card>
    </validation-observer>
  </v-container>
</template>

<script>
import checkPermission from '@/utils/permission'
export default {
  middleware: 'auth',
  data: () => ({
    id: null,
    accountUpdating: false,
    isLoading: false,
    passwordChanging: false,
    passwordForm: {
      current_password: null,
      password: null,
      password_confirmation: null
    },
    errorMessages: null,
    errors: null
  }),
  computed: {
    hasErrors () {
      return this.errorMessages !== null
    },
    informationForm () {
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email
      }
    },
    getUserId () {
      return this.$store.getters.loggedInUser.id
    },
    getName () {
      return this.$store.getters.loggedInUser.first_name
    },
    getLastName () {
      return this.$store.getters.loggedInUser.last_name
    },
    getEmail () {
      return this.$store.getters.loggedInUser.email
    },
    hasError () {
      return this.error !== null
    },

    isSaving () {
      return false
    }
  },
  created () {
    this.setExistedInformation()
  },
  methods: {
    checkPermission,
    setExistedInformation () {
      this.first_name = this.getName
      this.last_name = this.getLastName
      this.email = this.getEmail
    },
    async onSave () {
      this.isLoading = true
      try {
        await this.$axios.$put('user/' + this.getUserId, this.informationForm)
        this.isLoading = false
      } catch (err) {
        this.isLoading = false
        if (err.response) {
          this.$refs.observer.setErrors(
            err.response.data.errors
          )
        } else if (err.request) {
          this.error = 'Service Unavailable'
        } else {
          this.error = 'Internal Server Error'
        }
      }
    },
    async changePassword () {
      try {
        await this.$axios.$put('/user/password', this.passwordForm)
        this.passwordForm = {
          current_password: null,
          password: null,
          password_confirmation: null
        }
      } catch (err) {
        if (err.response) {
          this.$refs.observer.setErrors(
            err.response.data.errors
          )
        } else if (err.request) {
          this.error = 'Service Unavailable'
        } else {
          this.error = 'Internal Server Error'
        }
      }
    },
    onCloseNotification () {
      this.error = null
    }
  }
}
</script>

<style scoped>

</style>
