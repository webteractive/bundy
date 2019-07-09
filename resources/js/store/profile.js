import logs from './paginated'

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

const modules = {
  logs
}

export default {
  state,
  getters,
  actions,
  modules,
  mutations,
  namespaced: true
}