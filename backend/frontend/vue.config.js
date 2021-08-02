const port = process.env.PORT || process.env.npm_config_port || 9527 // dev port

module.exports = {
  publicPath: process.env.BASE_URL,
  transpileDependencies: ["vuetify"],
  pluginOptions: {
    i18n: {
      locale: "en",
      fallbackLocale: "en",
      localeDir: "locales",
      enableInSFC: false,
    },
  },
  devServer: {
    host: '0.0.0.0',
    port: port,
    disableHostCheck: true,
    proxy: process.env.BASE_URL,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
      'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Authorization',
    },
  },
  outputDir: '../public',
  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath: process.env.NODE_ENV === 'production'
      ? '../resources/views/index.blade.php'
      : 'index.html'
};
