const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');

require('laravel-mix-alias')
require('laravel-mix-purgecss')

mix.webpackConfig({
   plugins: [
      new MomentLocalesPlugin()
   ]
})

mix.alias({
   '~': '/resources',
   '@': '/resources/js',
   '@components': '/resources/js/components',
})

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/flatpickr/dist/flatpickr.js', 'public/js')
   .copy('node_modules/flatpickr/dist/themes/dark.css', 'public/css/flatpickr.css')
   .copy('node_modules/textarea-autogrow/textarea-autogrow.min.js', 'public/js/textarea-autogrow.js')
   .options({
      processCssUrls: false,
      postCss: [ tailwindcss() ],
   })
   .disableSuccessNotifications()
   .version()

