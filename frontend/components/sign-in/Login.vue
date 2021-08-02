<template>
  <v-container>
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
          Log in
          <v-spacer />
          <NuxtLink
            class="mx-2 links"
            to="/sign-up"
          >
            <span>Sign up as a student</span>
          </NuxtLink>
          <span style="font-size: 14px">or</span>
          <NuxtLink
            class="mx-2 links"
            to="/sign-up-tutor"
          >
            Sign up as a tutor
          </NuxtLink>
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
                    vid="unauthorized"
                  >
                    <v-text-field
                      ref="email"
                      v-model.trim="loginForm.email"
                      type="email"
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
                      v-model.trim="loginForm.password"
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
                    class="capitalized-btn"
                    :loading="isLoading"
                    @click="handleSubmit(onLogin)"
                  >
                    Log In
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
          </validation-observer>
        </v-card-text>
      </v-container>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: 'Login',
  components: {
    Notification: () => import('@/components/base/Notification')
  },
  data: () => ({
    loginForm: {
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
    async onLogin () {
      this.isLoading = true

      await this.$auth.loginWith('passwordGrant', {
        data: {
          email: this.loginForm.email,
          password: this.loginForm.password
        }
      }).then(() => {
        // eslint-disable-next-line no-console
        console.log('after login')
        this.isLoading = false
        this.resetForm()
        this.$router.push({ name: 'dashboard' })
      }, (e) => {
        this.isLoading = false
        if (e.response) {
          this.$refs.observer.setErrors(
            e.response.data.errors
          )
        } else if (e.request) {
          this.error = 'Service Unavailable'
        } else {
          this.error = 'Internal Server Error'
        }
      })
    },
    resetForm () {
      Object.keys(this.loginForm).forEach((f) => {
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
