const state = () => ({
  details: null
});

const getters = {
  details: state => state.details,
  authenticated: state => state.details !== null,
  scheduled: state => state.details !== null && state.details.schedules.length > 0,
  unscheduled: state => state.details !== null && state.details.schedules.length === 0,
  hasPostedScrum: state => state.details !== null && state.details.todays_scrum !== null,
  hasClockedIn: state => state.details !== null && state.details.todays_time_log !== null,
  hasNotClockedIn: state => state.details !== null && state.details.todays_time_log === null,
}

const mutations = {
  hydrate (state, details) {
    state.details = details
  }
}

const actions = {
  hydrate ({ commit }, details) {
    commit('hydrate', details)
  },

  logout ({ commit }) {
    commit('hydrate', null)
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}