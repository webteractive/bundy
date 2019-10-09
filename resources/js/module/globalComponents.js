import Tab from '../components/Tab'
import Warp from '../components/Warp'
import Logo from '../components/Logo'
import Face from '../components/Face'
import Shoe from '../components/Shoe'
import Modal from '../components/Modal'
import Field from '../components/Field'
import Bundy from '../components/Bundy'
import Accent from '../components/Accent'
import Logout from '../components/Logout'
import Helmet from '../components/Helmet'
import Widget from '../components/Widget'
import Fetcher from '../components/Fetcher'
import LiveDate from '../components/LiveDate'
import UserPhoto from '../components/UserPhoto'
import TheButton from '../components/TheButton'
import Layout from '../components/TwitterLayout'
import PushButton from '../components/PushButton'
import TimeLogger from '../components/TimeLogger'
import PageLayout from '../components/PageLayout'
import ContentTitle from '../components/ContentTitle'
import Webteractive from '../components/Webteractive'
import CustomSelect from '../components/CustomSelect'
import ErrorManager from '../components/ErrorManager'
import MasterLayout from '../components/MasterLayout'
import OnClickOutside from '../components/OnClickOutside'
import NothingToShowYet from '../components/NothingToShowYet'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

export default {
    install (Vue) {
        Vue.component('tab', Tab)
        Vue.component('warp', Warp)
        Vue.component('shoe', Shoe)
        Vue.component('face', Face)
        Vue.component('logo', Logo)
        Vue.component('field', Field)
        Vue.component('bundy', Bundy)
        Vue.component('modal', Modal)
        Vue.component('widget', Widget)
        Vue.component('layout', Layout)
        Vue.component('logout', Logout)
        Vue.component('accent', Accent)
        Vue.component('helmet', Helmet)
        Vue.component('btn', PushButton)
        Vue.component('ct', ContentTitle)
        Vue.component('fetcher', Fetcher)
        Vue.component('live-date', LiveDate)
        Vue.component('fa', FontAwesomeIcon)
        Vue.component('the-button', TheButton)
        Vue.component('user-photo', UserPhoto)
        Vue.component('time-logger', TimeLogger)
        Vue.component('page-layout', PageLayout)
        Vue.component('bundy-select', CustomSelect)
        Vue.component('webteractive', Webteractive)
        Vue.component('error-manager', ErrorManager)
        Vue.component('master-layout', MasterLayout)
        Vue.component('on-click-outside', OnClickOutside)
        Vue.component('nothing-to-show-yet', NothingToShowYet)
    }
}
