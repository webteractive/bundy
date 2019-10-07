import Login from './components/Login'
import HomePage from './components/HomePage'
import ProfilePage from './components/ProfilePage'
import AccountPage from './components/AccountPage'
import SchedulesPage from './components/SchedulesPage'
import PerformancePage from './components/PerformancePage'
import NotificationsPage from './components/NotificationsPage'
import AnnouncementsPage from './components/AnnouncementsPage'
import ProfileWall from './components/ProfileWall'
import ProfileLogs from './components/ProfileLogs'
import ProfileScrums from './components/ProfileScrums'
import ProfileLeaves from './components/ProfileLeaves'
import EditProfilePage from './components/EditProfilePage'
import SettingsPage from './components/SettingsPage'
import AdminPage from './components/AdminPage'
import AdminDashboard from './components/AdminDashboard'
import AdminUsers from './components/AdminUsers'
import AdminScheduleRequests from './components/AdminScheduleRequests'
import AdminLeaveRequests from './components/AdminLeaveRequests'
import AdminRemote from './components/AdminRemote'

export default [
  {name: 'home', path: '/', component: HomePage},
  {name: 'performance', path: '/performance', component: PerformancePage},
  {name: 'notifications', path: '/notifications', component: NotificationsPage},
  {name: 'announcements', path: '/announcements', component: AnnouncementsPage},
  {name: 'account', path: '/account', component: AccountPage},
  {name: 'schedules', path: '/schedules', component: SchedulesPage},
  {name: 'settings', path: '/settings', component: SettingsPage},
  {name: 'profile.edit', path: '/profile/edit', component: EditProfilePage},
  {
    path: '/profile/:username',
    component: ProfilePage,
    children: [
      {name: 'profile', path: 'scrums', component: ProfileScrums},
      {name: 'profile.logs', path: 'logs', component: ProfileLogs},
      {name: 'profile.leaves', path: 'leaves', component: ProfileLeaves},
      {name: 'profile.scrums', path: 'scrums', component: ProfileScrums},
    ]
  },
  {
    path: '/admin',
    component: AdminPage,
    children: [
      {name: 'admin', path: '', component: AdminDashboard},
      {name: 'admin.users', path: 'users', component: AdminUsers},
      {name: 'admin.schedules', path: 'schedules', component: AdminScheduleRequests},
      {name: 'admin.leaves', path: 'leaves', component: AdminLeaveRequests},
      {name: 'admin.remotes', path: 'remotes', component: AdminRemote},
    ]
  },
  {name: 'login', path: '/login', component: Login},
]