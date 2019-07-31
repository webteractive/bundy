const state = {
  users: [],
  timeLogs: []
}

const getters = {
  users: state => state.users,
  timeLogs: state => state.timeLogs
}

const mutations = {
  hydrate (state, { users, timeLogs }) {
    state.users = users
    state.timeLogs = timeLogs
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
  mutations,
  namespaced: true
}