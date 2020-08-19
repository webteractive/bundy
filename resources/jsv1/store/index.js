import nav from './nav'
import user from './user'
import clock from './clock'
import scrum from './scrum'
import stream from './stream'
import profile from './profile'
import admin from './admin/index'
import performance from './performance'
import notification from './notification'

const state = {
  ip: null,
  roles: [],
  schedules: [],
  workingRemote: false,
  birthdayCelebrant: null,
}

const getters = {
  ip: state => state.ip,
  roles: state => state.roles,
  schedules: state => state.schedules,
  workingRemote: state => state.workingRemote,
  birthdayCelebrant: state => state.birthdayCelebrant
}

const mutations = {
  hydrate (state, payload) {
    const {
      ip,
      apis,
      roles,
      schedules,
      workingRemote,
      birthdayCelebrant
    } = payload

    state.ip = ip
    state.apis = apis
    state.roles = roles
    state.schedules = schedules
    state.workingRemote = workingRemote
    state.birthdayCelebrant = birthdayCelebrant
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
  performance,
  notification
}

export default {
  state,
  getters,
  actions,
  modules,
  mutations,
}