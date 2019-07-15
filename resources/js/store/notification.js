const state = () => ({
  items: [],
})

const getters = {
  all: state => state.items,
  unread: state => state.items.filter(item => item.read_at === null)
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
