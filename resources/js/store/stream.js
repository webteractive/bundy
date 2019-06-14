const state = () => ({
  items: []
})

const getters = {
  items: state => state.items
}

const mutations = {
  hydrate (state, items) {
    state.items = items
  }
}

const actions = {
  hydrate ({ commit }, items) {
    commit('hydrate', items)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}