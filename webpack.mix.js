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
   .options({
      processCssUrls: false,
      postCss: [ tailwindcss() ],
   })
   .disableSuccessNotifications()
   .purgeCss()
