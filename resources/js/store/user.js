const state = () => ({
  details: null
});

const getters = {
  details: state => state.details,
  authenticated: state => state.details !== null
}

const mutations = {
  hydrate (state, details) {
    state.details = details
  }
}

const actions = {
  hydrate ({ commit }, details) {
    commit('hydrate', details)
  },

  logout ({ commit }) {
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