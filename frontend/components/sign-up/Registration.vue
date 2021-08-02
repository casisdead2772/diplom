<template>
  <div>
    <notification
      :state="hasError"
      :message="error"
      :color="'red'"
      @close="onCloseNotification"
    />
    <v-card
      outlined
      tile
      class="mx-auto my-12"
      max-width="574"
    >
      <v-container fluid>
        <v-card-title>
          <span class="title mb-1">Sign up as a student</span>
          <v-spacer />
          <span class="body-2">Already have an account?</span>
          <nuxt-link to="/sign-in" class="mx-2 links">
            Log In
          </nuxt-link>
        </v-card-title>
        <v-divider
          class="mx-4"
        />
        <v-card-text>
          <validation-observer
            ref="observer"
            v-slot="{ invalid, validated, handleSubmit }"
          >
            <v-form
              ref="form"
            >
              <v-row
                align="center"
                justify="center"
                class="pt-8"
              >
                <v-col
                  cols="10"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    name="Email"
                    rules="required|email"
                    vid="email"
                  >
                    <v-text-field
                      ref="email"
                      v-model.trim="registrationForm.email"
                      required
                      outlined
                      dense
                      label="Email"
                      color="primary"
                      :error-messages="errors"
                    />
                  </validation-provider>
                </v-col>
                <v-col
                  cols="10"
                  class="pb-0 mb-0"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    name="Password"
                    rules="required|min:3|max:25"
                    vid="password"
                  >
                    <v-text-field
                      ref="password"
                      v-model.trim="registrationForm.password"
                      label="Password"
                      required
                      outlined
                      dense
                      color="primary"
                      :error-messages="errors"
                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="showPassword ? 'text' : 'password'"
                      @click:append="showPassword = !showPassword"
                    />
                  </validation-provider>
                </v-col>
                <v-col
                  cols="10"
                >
                  <v-btn
                    depressed
                    color="primary"
                    class="capitalized"
                    :loading="isLoading"
                    @click="handleSubmit(onRegistration)"
                  >
                    Create account
                  </v-btn>
                </v-col>
                <v-col
                  cols="10"
                >
                  <div>
                    By clicking Continue with or Sign up, you agree to Teach For Me’s
                    <template>
                      <a
                        target="_blank"
                        href="#"
                        style="color: #00BFA5"
                        @click.stop
                      >
                        Terms of Service
                      </a>
                    </template>
                    and
                    <template>
                      <a
                        target="_blank"
                        href="#"
                        style="color: #00BFA5"
                        @click.stop
                      >
                        Privacy Policy
                      </a>
                    </template>
                  </div>
                </v-col>
              </v-row>
            </v-form>
          </validation-observer>
        </v-card-text>
      </v-container>
    </v-card>
  </div>
</template>

<script>

export default {
  name: 'Registration',
  components: {
    Notification: () => import('@/components/base/Notification')
  },
  data: () => ({
    registrationForm: {
      email: null,
      password: null
    },
    showPassword: false,
    error: null,
    isLoading: false
  }),
  computed: {
    hasError () {
      return this.error !== null
    }
  },
  methods: {
    async onRegistration () {
      this.isLoading = true
      try {
        await this.$axios.post('auth/registration', this.registrationForm)
        await this.$auth.loginWith('passwordGrant', {
          data: {
            email: this.registrationForm.email,
            password: this.registrationForm.password
          }
        })
        this.isLoading = false
        await this.resetForm()
        this.$router.push({ name: 'dashboard' }).catch((err) => {
          throw new Error(`Problem handling something: ${err}.`)
        })
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
      this.isLoading = false
    },
    resetForm () {
      Object.keys(this.registrationForm).forEach((f) => {
        this.$refs[f].reset()
      })
      this.$nextTick(() => {
        this.$refs.observer.reset()
      })
    },
    onCloseNotification () {
      this.error = null
    }
  }
}
</script>
