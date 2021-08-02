<template>
  <v-footer color="footer" style="text-align: center">
    <v-container fluid>
      <v-row>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
        >
          <div>
            <ul>
              <li>
                <h4 class="teal--text text--accent-3 mb-3">
                  About us
                </h4>
              </li>
              <li>
                <NuxtLink
                  to="/how-it-works"
                  title="How it works"
                  class="linkApp"
                >
                  How it works
                </NuxtLink>
              </li>
              <li>
                <NuxtLink
                  to="/price"
                  title="Price"
                  class="linkApp"
                >
                  Price
                </NuxtLink>
              </li>
              <li>
                <NuxtLink
                  to="/referral-programm"
                  title="Referral programm"
                  class="linkApp"
                >
                  Referral program
                </NuxtLink>
              </li>
            </ul>
          </div>
        </v-col>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
          class="pl-lg-8 pl-xl-8"
        >
          <div>
            <ul class="pl-0">
              <li>
                <h4 class="teal--text text--accent-3 mb-3">
                  Learn
                </h4>
              </li>
              <li>
                <router-link
                  to="/blog"
                  title="4Teaching Blog"
                  class="linkApp"
                >
                  4Teaching Blog
                </router-link>
              </li>
              <li>
                <router-link
                  to="/answertoquestion"
                  title="AnswerToQuestion"
                  class="linkApp"
                >
                  AnswerToQuestion
                </router-link>
              </li>
              <li>
                <router-link
                  to="/how-to-learn"
                  title="How to learn"
                  class="linkApp"
                >
                  How to learn
                </router-link>
              </li>
            </ul>
          </div>
        </v-col>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
          class="pl-lg-8 pl-xl-8"
        >
          <div>
            <ul class="pl-0">
              <li>
                <h4 class="teal--text text--accent-3 mb-3">
                  Job opportunities
                </h4>
              </li>
              <li>
                <router-link
                  to="/sign-up-tutor"
                  title="Become an online tutor"
                  class="linkApp"
                >
                  Become an online tutor
                </router-link>
              </li>
              <li>
                <router-link
                  to="/tutoring-jobs"
                  title="Online tutoring jobs"
                  class="linkApp"
                >
                  Online tutoring jobs
                </router-link>
              </li>
              <li>
                <router-link
                  to="/careers"
                  title="4Teaching careers"
                  class="linkApp"
                >
                  Work at 4Teaching!
                </router-link>
              </li>
            </ul>
          </div>
        </v-col>
      </v-row>
      <v-divider class="mt-2" />
      <v-row>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
          class="pl-lg-8 pl-xl-8"
        >
          <div>
            <v-list-item dark--text class="pa-0" color="teal--text text--accent-1">
              <v-list-item-content>
                <v-list-item-title class="teal--text text--accent-3 mb-3">
                  <h4>Support</h4>
                </v-list-item-title>
                <v-list-item-subtitle :class="$vuetify.theme.dark ? 'white--text' : 'black--text'">
                  Need any help?
                  <br>
                  support@4teaching.com
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>
        </v-col>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
          class="pl-lg-8 pl-xl-8"
        >
          <div>
            <v-list-item dark--text class="pa-0">
              <v-list-item-content>
                <v-list-item-title class="teal--text text--accent-3 mb-3">
                  <h4>Contacts</h4>
                </v-list-item-title>
                <v-list-item-subtitle :class="$vuetify.theme.dark ? 'white--text' : 'black--text'">
                  Belarus
                  <br>
                  Minsk
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>
        </v-col>
        <v-col
          cols="12"
          md="4"
          lg="4"
          sm="4"
          xs="8"
          class="pl-lg-8 pl-xl-8"
        >
          <div>
            <v-list-item dark--text class="pa-0">
              <v-list-item-content>
                <v-list-item-title class="teal--text text--accent-3 mb-3">
                  <h4>Social networks</h4>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <v-btn
                    v-for="(item, i) in items"
                    :key="i"
                    :href="item.link"
                    dark
                    icon
                  >
                    <v-icon :color="$vuetify.theme.dark ? 'white' : 'rgba(35,34,40,0.91)'" v-text="item.icon" />
                  </v-btn>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
export default {
  name: 'Footer',
  data () {
    return {
      items: [
        { icon: 'mdi-facebook', link: 'https://www.facebook.com/' },
        { icon: 'mdi-twitter', link: 'https://twitter.com/' },
        { icon: 'mdi-linkedin', link: 'https://www.linkedin.com/' },
        { icon: 'mdi-instagram', link: 'https://www.instagram.com/' }
      ]
    }
  }
}
</script>

<style scoped>
.line {
  width: 80%;
  border-bottom: 1px solid gray;
}

li {
  list-style-type: none;
}

</style>
