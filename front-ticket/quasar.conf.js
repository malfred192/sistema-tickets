/*
 * This file runs in a Node context (it's NOT transpiled by Babel), so use only
 * the ES6 features that are supported by your Node version. https://node.green/
 */

// Configuration for your app
// https://v1.quasar.dev/quasar-cli/quasar-conf-js
/* eslint-disable @typescript-eslint/no-var-requires */
const { configure } = require('quasar/wrappers');

module.exports = configure(function (ctx) {
  return {
    // https://v1.quasar.dev/quasar-cli/supporting-ts
    supportTS: true,

    // https://v1.quasar.dev/quasar-cli/prefetch-feature
    // preFetch: true,

    // app boot file (/src/boot)
    // --> boot files are part of "main.js"
    // https://v1.quasar.dev/quasar-cli/boot-files
    boot: [
      "composition-api","axios","vuelidate"],

    // https://v1.quasar.dev/quasar-cli/quasar-conf-js#Property%3A-css
    css: [
      'app.scss'
    ],

    // https://github.com/quasarframework/quasar/tree/dev/extras
    extras: [
      // 'ionicons-v4',
      // 'mdi-v5',
       'fontawesome-v5',
      // 'eva-icons',
      // 'themify',
      // 'line-awesome',
      // 'roboto-font-latin-ext', // this or either 'roboto-font', NEVER both!

      'roboto-font', // optional, you are not bound to it
      'material-icons', // optional, you are not bound to it
    ],

    // Full list of options: https://v1.quasar.dev/quasar-cli/quasar-conf-js#Property%3A-build
    build: {
      scopeHoisting: true,
      vueRouterMode: 'hash', // available values: 'hash', 'history'


      env: ctx.dev ? {API_URL: JSON.stringify('tickets/').replace(/['"]+/g, '')}:
      { 
        API_URL: JSON.stringify('http://127.0.0.1:8000/api/'),
        PRUEBA:ctx.dev
      },

     
      chainWebpack (cfg) {
        //
      },
    },

    // Full list of options: https://v1.quasar.dev/quasar-cli/quasar-conf-js#Property%3A-devServer
    devServer: {
     // https: false,
     // port: 8080,
     proxy: {

      '/tickets': {
        target: 'http://127.0.0.1:8000/api',
        changeOrigin: true,
        https: false,
        pathRewrite: {
          '^/tickets': ''
        }
      },




     // '/monitoreo': 'http://127.0.0.1:8000/api', 
      changeOrigin: true,
    },
      open: true // opens browser window automatically
    },

    // https://v1.quasar.dev/quasar-cli/quasar-conf-js#Property%3A-framework
    framework: {
      iconSet: 'material-icons', // Quasar icon set
      lang: 'es', // Quasar language pack
      config: {
        brand: {
          primary: "#111c4c",
          secondary: "#009688",
          accent: "#313945",
          positive: "#2E7D32",
          negative: "#9B1D21",
          info: "#2196F3",
          warning: "#FFB300"
        }
      },

      // Possible values for "importStrategy":
      // * 'auto' - (DEFAULT) Auto-import needed Quasar components & directives
      // * 'all'  - Manually specify what to import
      importStrategy: 'auto',

      // For special cases outside of where "auto" importStrategy can have an impact
      // (like functional components as one of the examples),
      // you can manually specify Quasar components/directives to be available everywhere:
      //
      // components: [],
      // directives: [],

      // Quasar plugins
      plugins: ['Notify', 'LoadingBar','Dialog','Loading','LocalStorage','SessionStorage']
    },

    // animations: 'all', // --- includes all animations
    // https://v1.quasar.dev/options/animations
    animations: [],

    // https://v1.quasar.dev/quasar-cli/developing-ssr/configuring-ssr
    ssr: {
      pwa: false
    },

    // https://v1.quasar.dev/quasar-cli/developing-pwa/configuring-pwa
    pwa: {
      workboxPluginMode: 'GenerateSW', // 'GenerateSW' or 'InjectManifest'
      workboxOptions: {}, // only for GenerateSW
      manifest: {
        name: `Sistema Tickets`,
        short_name: `Sistema Tickets`,
        description: `Sistema de Gestión de tickets`,
        display: 'standalone',
        orientation: 'portrait',
        background_color: '#ffffff',
        theme_color: '#027be3',
        icons: [
          {
            src: 'icons/icon-128x128.png',
            sizes: '128x128',
            type: 'image/png'
          },
          {
            src: 'icons/icon-192x192.png',
            sizes: '192x192',
            type: 'image/png'
          },
          {
            src: 'icons/icon-256x256.png',
            sizes: '256x256',
            type: 'image/png'
          },
          {
            src: 'icons/icon-384x384.png',
            sizes: '384x384',
            type: 'image/png'
          },
          {
            src: 'icons/icon-512x512.png',
            sizes: '512x512',
            type: 'image/png'
          }
        ]
      }
    },

    // Full list of options: https://v1.quasar.dev/quasar-cli/developing-cordova-apps/configuring-cordova
    cordova: {
      // noIosLegacyBuildFlag: true, // uncomment only if you know what you are doing
    },

    // Full list of options: https://v1.quasar.dev/quasar-cli/developing-capacitor-apps/configuring-capacitor
    capacitor: {
      hideSplashscreen: true
    },

    // Full list of options: https://v1.quasar.dev/quasar-cli/developing-electron-apps/configuring-electron
    electron: {
      bundler: 'packager', // 'packager' or 'builder'

      packager: {
        // https://github.com/electron-userland/electron-packager/blob/master/docs/api.md#options

        // OS X / Mac App Store
        // appBundleId: '',
        // appCategoryType: '',
        // osxSign: '',
        // protocol: 'myapp://path',

        // Windows only
        // win32metadata: { ... }
      },

      builder: {
        // https://www.electron.build/configuration/configuration

        appId: 'front_tickets'
      },

      // More info: https://v1.quasar.dev/quasar-cli/developing-electron-apps/node-integration
      nodeIntegration: true,

      extendWebpack (/* cfg */) {
        // do something with Electron main process Webpack cfg
        // chainWebpack also available besides this extendWebpack
      }
    }
  }
});
