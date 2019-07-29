import omit from 'lodash.omit'
import merge from 'lodash.merge'

const state = () => ({
  pagination: {
    to: 0,
    from: 1,
    data: [],
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
    return {
      items: state.pagination.data,
      pagination: omit(state.pagination, ['data']),
    }
  },
}

const mutations = {
  paginate (state, pagination) {
    state.pagination = pagination
  },

  concat (state, pagination) {
    state.pagination = {
      pagination: omit(pagination, ['data']),
      data: state.pagination.data.concat(pagination.data) 
    };
  }
}

const actions = {
  paginate ({ commit }, pagination) {
    commit('paginate', pagination)
  },

  concat ({ commit }, pagination) {
    commit('concat', pagination)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}