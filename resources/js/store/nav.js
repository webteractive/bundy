const { home } = BUNDY.apis
const { page, identifier, inner } = BUNDY.request

const state = () => ({
  inner,
  identifier,
  page: page === null ? 'home' : page,
  items: [
    ['home', 'home', false, 'menu'],
    ['search', 'search', true, 'search'],
    ['notifications', 'bell', false, 'menu'],
    ['announcements', 'bullhorn', false, 'menu'],
    ['profile', 'user', true, 'userPane'],
    ['admin', 'user-astronaut', true, 'userPane'],
    ['settings', 'sliders-h', true, 'userPane'],
    ['schedules', 'sliders-h', true, 'sidebar'],
    ['edit-profile', 'sliders-h', true, 'sidebar'],
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
      const [name,, hidden, position] = item
      return hidden === true && name !== 'search' && position === 'userPane'
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

    history.pushState(state, name, url)
  },

  warp (state, {inner, identifier, page}) {
    state.page = page
    state.inner = inner
    state.identifier = identifier
  }
}

const actions = {
  navigate ({ commit }, payload) {
    commit('navigate', payload)
  },

  warp ({ commit }, state) {
    commit('warp', state)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}