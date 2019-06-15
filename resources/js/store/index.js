import nav from './nav'
import user from './user'
import scrum from './scrum'
import stream from './stream'
import profile from './profile'

const state = {
  ip: null,
  schedules: []
}

const getters = {
  ip: state => state.ip,
  schedules: state => state.schedules
}

const mutations = {
  hydrate (state, payload) {
    const { ip, schedules, apis } = payload
    state.ip = ip
    state.apis = apis
    state.schedules = schedules
  }
}

const actions = {
  hydrate ({ commit }, payload) {
    commit('hydrate', payload)
  }
}

const modules = {
  nav,
  user,
  scrum,
  stream,
  profile
}

export default {
  state,
  getters,
  actions,
  modules,
  mutations,
}