import qsManager from 'qs'
import merge from 'lodash.merge'
import { http } from '../module/http'

const { request, pages: items } = BUNDY
const { page, identifier, inner, qs } = request

const state = () => ({
  qs,
  inner,
  items,
  identifier,
  page: page === null ? 'home' : page
})

const getters = {
  allItems: state => state.items,
  items: state => {
    return state.items.filter(item => {
      const [,, hidden] = item
      return hidden !== true
    })
  },

  user: state => {
    return state.items.filter(item => {
      const [name,, hidden, position] = item
      return hidden === true && name !== 'search' && position.includes('userPane')
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

    const param = merge({page: page === 'home' ? null : page, inner, identifier}, qs)
    const url = http.resolveURL('home', param, true)
    const [ name ] = state.items.find(item => {
      const [ name ] = item
      return page === name 
    })
    
    state.page = page
    state.inner = inner
    state.identifier = identifier
    state.qs = typeof qs === 'undefined' ? null : qs

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