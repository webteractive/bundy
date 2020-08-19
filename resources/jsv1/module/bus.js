class EventBus {
  constructor(Vue) {
    this.bus = new Vue()
  }

  emit (event, payload) {
    this.bus.$emit(event, payload)
  }

  on (event, callback) {
    this.bus.$on(event, callback)
  }
}

export default {
  install (Vue) {
    Vue.prototype.$bus = new EventBus(Vue)
  }
}