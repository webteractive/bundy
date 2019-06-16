import formatDate from 'date-fns/format'

const state = () => ({
  time: new Date().getTime()
})

const getters = {
  time: state => state.time,
  dayOfTheWeek: state => parseInt(formatDate(state.time, 'd')),
  dayOfTheWeekString: state => formatDate(state.time, 'dddd'),
}

const mutations = {
  tick (state) {
    const date = new Date()
    state.time = date.getTime()
  }
}

const actions = {
  tick ({ commit }) {
    commit('tick')
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
  namespaced: true
}