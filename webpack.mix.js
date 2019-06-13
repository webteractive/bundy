const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');

mix.webpackConfig({
   plugins: [
      new MomentLocalesPlugin()
   ]
})

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .options({
      processCssUrls: false,
      postCss: [ tailwindcss('./tailwind.config.js') ],
   })
   .disableSuccessNotifications()
