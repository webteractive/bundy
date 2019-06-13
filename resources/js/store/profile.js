const state = () => ({
  details: null
})

const getters = {
  details: state => state.details
}

const mutations = {
  hydrate (state, details) {
    state.details = details
  }
}

const actions = {
  hydrate ({ commit }, details) {
    commit('hydrate', details)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}