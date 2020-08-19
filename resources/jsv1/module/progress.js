import merge from 'lodash.merge'
import NProgress from 'nprogress'

import 'nprogress/nprogress.css'

export default {
  install (Vue, options = {}) {
    NProgress.configure(merge({
      minimum: 0.1,
      showSpinner: false
    }, options))

    Vue.prototype.$progress = NProgress
  }
}