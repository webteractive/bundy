const state = () => ({
  shown: false,
  details: null
})

const getters = {
  shown: state => state.shown,
  details: state => state.details
}

const mutations = {
  toggle (state, shown) {
    state.shown = shown
  },

  hydrate (state, details) {
    state.details = details
  }
}

const actions = {
  toggle ({ commit }, shown) {
    commit('toggle', shown)
  },

  edit ({ commit }, details) {
    commit('toggle', true)
    commit('hydrate', details)
  },

  close ({ commit }) {
    commit('toggle', false)
    commit('hydrate', null)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}