import colors from 'vuetify/es5/util/colors'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader

export default {
  treeShake: true,
  icons: {
    iconfont: 'fa'
  },
  theme: {
    dark: false,
    themes: {
      dark: {
        primary: '#439889',
        accent: '#52c7b8',
        secondary: '#424242',
        navigation: '#121212',
        appBar: '#232228',
        footer: '#232228',
        text: '#FAFAFA',
        info: colors.teal.lighten1,
        warning: colors.amber.base,
        error: colors.deepOrange.accent4,
        success: colors.green.accent3
      },
      light: {
        primary: '#439889',
        accent: '#52c7b8',
        secondary: '#424242',
        text: '#020202',
        third: colors.blueGrey.darken4, // #E53935
        navigation: '#ececec',
        appBar: '#FAFAFA',
        footer: '#FAFAFA'
      }
    }
  }
}
