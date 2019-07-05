import qsManager from 'qs'
import { http } from '../module/http'

const home = http.resolveURL('home', {}, true)
const { page, identifier, inner, qs } = BUNDY.request

const state = () => ({
  qs,
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
    ['account', 'sliders-h', true, 'sidebar'],
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

  qs: state => state.qs,
  qsUrl: state => qsManager.stringify(state.qs),
  active: state => state.page,
  inner: state => state.inner,
  identifier: state => state.identifier,
  pages: state => {
    return state.items.map(item => {
      const [ page ] = item
      return page
    })
  }
}

const mutations = {
  navigate (state, { page, identifier, inner, qs }) {
    state.page = page
    state.inner = inner
    state.identifier = identifier

    state.qs = typeof qs === 'undefined' ? null : qs
    
    let url = home
    const [ name ] = state.items.find(item => {
      const [ name ] = item
      return page === name 
    })

    if (['home'].includes(page) === false) {
      url = `${url}/${page}`
    }

    if (typeof identifier !== 'undefined' && identifier !== null) {
      url = `${url}/${identifier}`
    }

    if (qs !== null) {
      let finalQs = qsManager.stringify(qs)
      if (finalQs.length > 0) {
        url = `${url}?${qsManager.stringify(qs)}`
      }
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