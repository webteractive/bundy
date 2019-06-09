const state = () => ({
  active: 'home',
  items: [
    'home',
    'logs',
    'leaves',
    'profile',
  ]
})

const getters = {
  items: state => state.items,
  active: state => state.active,
}

const mutations = {
  setActive (state, active) {
    state.active = active
  }
}

const actions = {
  setActive ({ commit }, active) {
    commit('setActive', active)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}