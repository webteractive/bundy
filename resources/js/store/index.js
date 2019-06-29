import nav from './nav'
import user from './user'
import clock from './clock'
import scrum from './scrum'
import stream from './stream'
import profile from './profile'
import admin from './admin/index'
import notification from './notification'

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
  admin,
  clock,
  scrum,
  stream,
  profile,
  notification
}

export default {
  state,
  getters,
  actions,
  modules,
  mutations,
}