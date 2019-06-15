const state = () => ({
  details: null
});

const getters = {
  details: state => state.details,
  authenticated: state => state.details !== null,
  scrumed: state => state.details.todays_scrum !== null,
  timeLogged: state => state.details.todays_time_log !== null,
  scheduled: state => state.details.scheduled && state.details.schedules.length > 0,
  unscheduled: state => state.details.scheduled === false && state.details.schedules.length === 0
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