const state = {
  user: null
}

const getters = {
  user: state => state.user,
  authenticated: state => state.user !== null
}

const mutations = {
  hydrate (state, { user }) {
    state.user = user
  }
}

const actions = {
  hydrate ({ commit }, payload) {
    commit('hydrate', payload)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}