<template>
  <v-row justify="center">
    <v-alert
      v-if="hasErrors"
      color="red"
      :text="errorMessages"
      type="error"
    />
    <v-col
      cols="12"
    >
      <validation-observer
        ref="observer"
        v-slot="{ invalid }"
      >
        <v-card
          ref="form"
          flat
          class="mx-auto"
          max-width="560"
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
                  ref="firstName"
                  v-model.trim="informationForm.first_name"
                  :error-messages="errors"
                  label="First name"
                  placeholder="John"
                  required
                  outlined
                  dense
                  :disabled="hasFirstName"
                />
              </validation-provider>
              <validation-provider
                v-slot="{ errors }"
                name="Last name"
                rules="required|max:20"
              >
                <v-text-field
                  ref="lastName"
                  v-model="informationForm.last_name"
                  :error-messages="errors"
                  label="Last name"
                  placeholder="Doe"
                  required
                  outlined
                  dense
                  :disabled="hasLastName"
                />
              </validation-provider>
              <validation-provider
                v-slot="{ errors }"
                name="Country"
                rules="required"
              >
                <v-autocomplete
                  ref="country"
                  v-model="informationForm.country_id"
                  :error-messages="errors"
                  :items="countryItems"
                  item-text="name"
                  item-value="id"
                  label="Country of origin"
                  placeholder="Chose country..."
                  required
                  outlined
                  dense
                  :disabled="hasCountry"
                />
              </validation-provider>
              <v-row
                :no-gutters="$vuetify.breakpoint.smAndDown"
              >
                <v-col
                  cols="12"
                  md="7"
                  lg="7"
                  xl="7"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    name="Language"
                    rules="required"
                  >
                    <v-autocomplete
                      ref="language"
                      v-model="informationForm.language_id"
                      :error-messages="errors"
                      :items="languageItems"
                      item-text="name"
                      item-value="id"
                      label="Languages spoken"
                      placeholder="Chose language..."
                      required
                      outlined
                      dense
                    />
                  </validation-provider>
                </v-col>
                <v-col
                  cols="12"
                  md="5"
                  lg="5"
                  xl="5"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    name="language grade"
                    rules="required"
                  >
                    <v-autocomplete
                      ref="language"
                      v-model="informationForm.language_grade_id"
                      :error-messages="errors"
                      :items="languageGradeItems"
                      item-text="name"
                      item-value="id"
                      label="Language level"
                      placeholder="Chose level..."
                      required
                      outlined
                      dense
                    />
                  </validation-provider>
                </v-col>
              </v-row>
              <validation-provider
                v-slot="{ errors }"
                name="Subject taught"
                rules="required"
              >
                <v-autocomplete
                  ref="subjectTaught"
                  v-model="informationForm.subject_taught_id"
                  :error-messages="errors"
                  :items="subjectTaughtItems"
                  item-text="name"
                  item-value="id"
                  label="Subject taught"
                  placeholder="Chose subject..."
                  required
                  outlined
                  dense
                />
              </validation-provider>
              <v-row
                :no-gutters="$vuetify.breakpoint.smAndDown"
              >
                <v-col
                  cols="12"
                  md="4"
                  lg="4"
                  xl="4"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    name="Hourly rate"
                    :rules="{required: true, min_value: 1, integer: true }"
                  >
                    <v-text-field
                      ref="hourlyRate"
                      v-model="informationForm.hourly_rate"
                      :error-messages="errors"
                      label="Hourly rate"
                      placeholder="Hourly rate"
                      required
                      outlined
                      dense
                      append-outer-icon="mdi-currency-usd"
                    />
                  </validation-provider>
                </v-col>
              </v-row>
            </form>
          </v-card-text>
          <v-card-actions class="pb-4">
            <v-btn
              color="primary"
              :loading="isLoading"
              depressed
              width="127"
              class="ml-2"
              :disabled="invalid"
              @click="onSave"
            >
              <v-icon
                left
                dark
              >
                mdi-floppy
              </v-icon>
              save
            </v-btn>
          </v-card-actions>
        </v-card>
      </validation-observer>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'AboutInformation',
  data: () => ({
    errorMessages: null,
    first_name: null,
    last_name: null,
    country_id: null,
    language_id: null,
    language_grade_id: null,
    subject_taught_id: null,
    hourly_rate: null,
    isLoading: false
  }),
  computed: {
    hasErrors () {
      return this.errorMessages !== null
    },
    isSaving () {
      return false
    },
    informationForm () {
      return {
        first_name: this.first_name,
        last_name: this.last_name,
        country_id: this.country_id,
        language_id: this.language_id,
        language_grade_id: this.language_grade_id,
        subject_taught_id: this.subject_taught_id,
        hourly_rate: this.hourly_rate
      }
    },
    userInformation () {
      return this.$store.getters.loggedInUser
    },
    countryItems () {
      return this.$store.state.base.countryItems
    },
    languageItems () {
      return this.$store.state.base.languageItems
    },
    languageGradeItems () {
      return this.$store.state.base.languageGradeItems
    },
    subjectTaughtItems () {
      return this.$store.state.base.subjectItems
    },
    requestItems () {
      return this.$store.state.base.requestItems
    },
    hasFirstName () {
      return this.$store.getters.loggedInUser.first_name !== null
    },
    hasLastName () {
      return this.$store.getters.loggedInUser.last_name !== null
    },
    hasCountry () {
      if (this.$store.getters.loggedInUser.teacher_info) {
        return this.$store.getters.loggedInUser.teacher_info.country !== null
      } else {
        return false
      }
    },
    hasSubjectTaught () {
      if (this.$store.getters.loggedInUser.teacher_info) {
        return this.$store.getters.loggedInUser.teacher_info.subject_taught !== null
      } else {
        return false
      }
    }
  },
  watch: {
    name () {
      this.errorMessages = ''
    }
  },
  created () {
    this.setExistedInformation()
  },
  methods: {
    setExistedInformation () {
      if (this.userInformation) {
        this.first_name = this.userInformation.first_name
        this.last_name = this.userInformation.last_name
        if (this.userInformation.teacher_info) {
          this.country_id = this.userInformation.teacher_info.country_id
          this.language_id = this.userInformation.teacher_info.languages[0].language
          this.language_grade_id = this.userInformation.teacher_info.languages[0].grade
          this.subject_taught_id = this.userInformation.teacher_info.subject_taught_id
          this.hourly_rate = this.userInformation.teacher_info.price_per_hour
        }
      }
    },
    async onSave () {
      this.isLoading = true
      try {
        await this.$refs.observer.validate()
        await this.$axios.$post('teacher-about/' + this.userInformation.id, this.informationForm)
        await this.$auth.fetchUser()
        await this.setExistedInformation()
        this.isLoading = false
      } catch (e) {
        // eslint-disable-next-line no-console
        console.log(e.response.data)
        this.isLoading = false
        this.errorMessages = e.response.data.errors[0]
      }
    }
  }
}
</script>
