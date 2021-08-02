<template>
  <v-row align="center" justify="center">
    <Notification
      :state="successBookNotify"
      :color="`green`"
      :message="`Lesson successfully reserved`"
      @close="successBookNotify = false"
    />
    <v-col cols="12">
      <v-card
        :loading="isLoading"
        width="auto"
        max-width="1215"
        class="mx-auto my-3"
        elevation="0"
        outlined
      >
        <v-card-title>
          Online English tutors & teachers
        </v-card-title>
        <v-card-text>
          <v-form>
            <v-container>
              <v-row>
                <v-col
                  cols="12"
                  xl="5"
                  lg="5"
                  md="5"
                  sm="12"
                >
                  <v-select
                    v-model="options.subject_id"
                    :items="subjectItems"
                    outlined
                    dense
                    hide-details
                    label="I want to learn"
                    item-text="name"
                    item-value="id"
                  />
                </v-col>
                <v-col
                  cols="12"
                  xl="3"
                  lg="3"
                  md="3"
                  sm="12"
                >
                  <v-row class="justify-xl-center justify-lg-center justify-md-center justify-sm-center">
                    <v-col
                      cols="6"
                      sm="3"
                      md="6"
                      lg="5"
                      xl="5"
                    >
                      <v-text-field
                        :value="pricePerHourRange[0]"
                        hide-details
                        dense
                        outlined
                        single-line
                        type="number"
                        :style="widthStyle"
                        suffix="$"
                        @change="$set(pricePerHourRange, 0, $event)"
                      />
                    </v-col>
                    <v-col
                      cols="6"
                      sm="3"
                      md="6"
                      lg="5"
                      xl="5"
                      class="pl-xl-7 pl-lg-5"
                    >
                      <v-text-field
                        :value="pricePerHourRange[1]"
                        hide-details
                        single-line
                        type="number"
                        dense
                        outlined
                        :style="widthStyle"
                        suffix="$"
                        @change="$set(pricePerHourRange, 1, $event)"
                      />
                    </v-col>
                    <v-col
                      cols="12"
                      sm="12"
                      md="12"
                      lg="10"
                      xl="10"
                    >
                      <v-range-slider
                        v-model="pricePerHourRange"
                        :max="maxPrice"
                        :min="minPrice"
                        step="5"
                        ticks
                        hide-details
                        class="align-center"
                        @end="onEndPriceRange"
                      />
                    </v-col>
                  </v-row>
                </v-col>
                <v-col
                  cols="12"
                  xl="4"
                  lg="4"
                  md="4"
                  sm="12"
                >
                  <v-autocomplete
                    v-model="options.country_id"
                    :items="countryItems"
                    outlined
                    dense
                    multiple
                    label="Tutor country"
                    item-text="name"
                    item-value="id"
                    clearable
                    @click:clear="onClearCountry"
                  >
                    <template v-slot:selection="{ item, index }">
                      <span v-if="index < maxDisplay">{{ item.name }} &nbsp;</span>
                      <span
                        v-if="index === maxDisplay"
                        class="grey--text caption"
                      >(+{{ options.country_id.length - maxDisplay }} countries)</span>
                    </template>
                  </v-autocomplete>
                </v-col>
              </v-row>
            </v-container>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12">
      <v-card
        v-for="(tutor, id) in tutors"
        :key="id"
        class="mx-auto"
        width="auto"
        max-width="615"
        outlined
      >
        <v-card-title> {{ tutor.first_name }} {{ tutor.last_name }}</v-card-title>
        <v-card-text>
          <v-row>Price per hour: {{ tutor.price_per_hour }}</v-row>
          <v-row>Country: {{ tutor.country }}</v-row>
          <v-row>Subject: {{ tutor.subject }}</v-row>
          <v-row>Language: {{ tutor.speaks[0].language }}</v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            text
            color="primary"
          >
            View
          </v-btn>
          <v-btn
            depressed
            color="primary"
            @click="onShowBook(tutor)"
          >
            Book lesson
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <div class="text-xs-center mt-4">
      <!--      <v-pagination-->
      <!--        v-model="options.page"-->
      <!--        :length="pagination.last_page"-->
      <!--        :total-visible="10"-->
      <!--        @input="handlePagination"-->
      <!--      />-->
    </div>
    <simple-dialog
      :dialog="showBookDialog"
      :btn-agree-txt="`Reserve`"
      :btn-cancel-txt="`Cancel`"
      :is-loading="isLoadingBook"
      :title="`Reserve lesson`"
      :hint="`Are you sure want to reserve a lesson?`"
      :callback="onBookLesson"
      @close="showBookDialog = false"
    />
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
      :title="`Choose time lesson`"
    >
      <v-card>
        <v-card-title>
          <span class="text-h5">Date and time</span>
        </v-card-title>
        <div :style="{ fontSize: 24 + 'px' }">
          <datetime
            v-model="datetimelesson"
            type="datetime"
            :minute-step="15"
          >
            Choose date
          </datetime>
        </div>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false
                    showBookDialog = true"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import moment from 'moment'
import { mapGetters } from 'vuex'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

export default {
  name: 'FindTutorFilter',
  components: {
    SimpleDialog: () => import('@/components/base/Dialog'),
    Notification: () => import('@/components/base/Notification'),
    datetime: Datetime
  },
  data () {
    return {
      activeColor: 'red',
      fontSize: 30,
      datetimelesson: moment(String(new Date())).format('YYYY-MM-DDT12:00:00.000Z'),
      tutors: [],
      dialog: false,
      totalTutors: 0,
      minPrice: 5,
      maxPrice: 100,
      pricePerHourRange: [5, 100],
      options: {
        price_per_hour_from: 5,
        price_per_hour_to: 100,
        subject_id: 1,
        country_id: null,
        page: 1,
        itemsPerPage: 10
      },
      isLoading: true,
      maxDisplay: 1,
      showBookDialog: false,
      isLoadingBook: false,
      successBookNotify: false
    }
  },
  computed: {
    ...mapGetters(['loggedInUser']),
    subjectItems () {
      return this.$store.state.base.subjectItems
    },
    countryItems () {
      return this.$store.state.base.countryItems
    },
    languageItems () {
      return this.$store.state.base.languageItems
    },
    availableTutor () {
      return `${this.totalTutors} tutor available`
    },
    pricePerHourLabel () {
      return this.options.price_per_hour_from + ' - ' + this.options.price_per_hour_to
    },
    widthStyle () {
      if (this.$vuetify.breakpoint.smAndDown) {
        return ''
      } else {
        return 'width: 80px'
      }
    }
  },
  watch: {
    options: {
      handler () {
        this.getTutors()
      },
      deep: true
    }
  },
  created () {
    this.getTutors()
  },
  methods: {
    async getTutors () {
      this.isLoading = true
      try {
        const { data } = await this.$axios.$get('teachers', { params: this.options })
        this.tutors = data.data
        this.options.page = data.current_page
        this.totalTutors = data.total
        this.isLoading = false
      } catch (e) {
        this.isLoading = false
      }
    },
    onClearCountry () {
      this.options.country_id = null
    },
    onEndPriceRange () {
      this.options.price_per_hour_from = this.pricePerHourRange[0]
      this.options.price_per_hour_to = this.pricePerHourRange[1]
    },
    /**
     * @param tutor
     */
    onShowBook (tutor) {
      if (this.loggedInUser) {
        this.selectedTutor = tutor
        this.dialog = true
      } else {
        // TODO
        // show login dialog
      }
    },
    async onBookLesson () {
      this.isLoadingBook = true
      try {
        console.log(this.datetimelesson)
        const { success } = await this.$axios.$post('reserve-lesson', { teacher_id: this.selectedTutor.id, datetime: this.datetimelesson })
        if (success) {
          this.showBookDialog = false
          this.successBookNotify = true
        }
        this.isLoadingBook = false
      } catch (e) {
        this.isLoadingBook = false
      }
    }
  }
}
</script>

<style scoped>

</style>
