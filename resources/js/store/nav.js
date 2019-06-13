const { home } = BUNDY.apis
const { page, identifier, inner } = BUNDY.request

const state = () => ({
  inner,
  identifier,
  page: page === null ? 'home' : page,
  items: [
    ['home', 'home', false],
    ['search', 'search', true],
    ['notifications', 'bell', false],
    ['announcements', 'bullhorn', false],
    ['profile', 'user', true],
    ['admin', 'user-astronaut', true],
    ['settings', 'sliders-h', true]
  ]
})

const getters = {
  items: state => {
    return state.items.filter(item => {
      const [,, hidden] = item
      return hidden !== true
    })
  },

  user: state => {
    return state.items.filter(item => {
      const [name,, hidden] = item
      return hidden === true && name !== 'search'
    });
  },

  active: state => state.page,
}

const mutations = {
  navigate (state, { page, identifier }) {
    state.page = page

    let url = home
    const [ name ] = state.items.find(item => {
      const [ name ] = item
      return page === name 
    })

    if (! ['home'].includes(page)) {
      url = `${url}/${page}`
    }

    if (typeof identifier !== 'undefined' && identifier !== null) {
      url = `${url}/${identifier}`
    }

    history.replaceState(state, name, url)
  }
}

const actions = {
  navigate ({ commit }, payload) {
    commit('navigate', payload)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}