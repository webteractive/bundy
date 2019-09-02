import user from '../paginated'
import schedule from './schedule'
import leaveRequest from '../paginated'
import scheduleRequest from '../paginated'

export default {
  namespaced: true,
  modules: {
    user,
    schedule,
    leaveRequest,
    scheduleRequest
  }
}