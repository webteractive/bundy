import omit from 'lodash.omit'
import merge from 'lodash.merge'

const state = () => ({
  pagination: {
    to: 0,
    from: 1,
    items: [],
    per_page: 1,
    total: 0,
    current_page: 1,
    last_page_url: null,
    next_page_url: null,
    prev_page_url: null,
    first_page_url: null,
  }
})

const getters = {
  pagination: state => {
    return merge(omit(state.pagination, ['data']), {
      items: state.pagination.data
    })
  },
}

const mutations = {
  paginate (state, pagination) {
    state.pagination = pagination
  }
}

const actions = {
  paginate ({ commit }, pagination) {
    commit('paginate', pagination)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}