export default {
  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    titleTemplate: '%s - 4-teaching',
    title: '4-teaching',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto' }
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    '~/plugins/vee-validate'
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
    // https://www.npmjs.com/package/@nuxtjs/moment
    '@nuxtjs/moment'
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // https://auth.nuxtjs.org/guide/setup.html
    '@nuxtjs/auth',
    'portal-vue/nuxt'
  ],

  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    baseURL: process.env.LARAVEL_ENDPOINT,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  },
  proxy: {
    '/api/v1': {
      target: process.env.LARAVEL_ENDPOINT,
      pathRewrite: {
        '^/api/v1': '/'
      }
    }
  },
  // https://auth.nuxtjs.org/guide/setup.html
  auth: {
    vuex: {
      namespace: 'auth'
    },
    tokenRequired: true,
    tokenType: 'Bearer',
    redirect: {
      login: '/dashboard',
      logout: '/',
      callback: '/login',
      home: '/dashboard'
    },
    strategies: {
      local: false,
      passwordGrant: {
        _scheme: 'local',
        token: {
          property: 'access_token',
          maxAge: 1800,
          type: 'Bearer'
        },
        refreshToken: {
          property: 'refresh_token',
          data: 'refresh_token',
          maxAge: 60 * 60 * 24 * 30
        },
        endpoints: {
          login: {
            url: 'auth/login',
            method: 'post',
            propertyName: 'data.access_token'
          },
          logout: {
            url: 'auth/logout',
            method: 'post'
          },
          user: {
            url: 'auth/me',
            method: 'get',
            propertyName: 'data'
          },
          refresh: {
            url: 'auth/refresh',
            method: 'post'
          }
        }
      }
    }
  },

  // Vuetify module configuration (https://go.nuxtjs.dev/config-vuetify)
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    optionsPath: './vuetify.options.js'
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
    transpile: ['vee-validate/dist/rules']
  },
  loading: {
    color: '#00BFA5',
    height: '2px'
  }
}
