import user from '../paginated'
import scheduleRequest from '../paginated'
import schedule from './schedule'

export default {
  namespaced: true,
  modules: {
    user,
    schedule,
    scheduleRequest
  }
}