import formatDate from 'date-fns/format'

const state = () => ({
  time: new Date().getTime()
})

const getters = {
  time: state => state.time,
  dayOfTheWeek: state => parseInt(formatDate(state.time, 'd')),
  dayOfTheWeekString: state => formatDate(state.time, 'dddd'),
  daysOfTheWeek: () => [
    {name: 'sunday', value: 0},
    {name: 'monday', value: 1},
    {name: 'tuesday', value: 2},
    {name: 'wednesday', value: 3},
    {name: 'thursday', value: 4},
    {name: 'friday', value: 5},
    {name: 'saturday', value: 6}
  ]
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