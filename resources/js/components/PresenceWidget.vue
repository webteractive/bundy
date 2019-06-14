<template>
  <div class="bg-white">
    <ct>Present</ct>
    <div class="flex flex-wrap p-4">
      <user-photo
        v-for="employee in employees"
        :key="employee.id"
        :title="employee.name"
        :user="employee"
        @click.native="show(employee)"
        size="12"
        class="z-auto h-8 h-8 mr-1 mb-1 border border-transparent cursor-pointer relative hover:border-green-500"
      >
        <span
          slot="extra"
          class="absolute h-4 w-4 top-0 right-0 bg-gray-400 rounded-full border-2 border-white"
        />
      </user-photo>
    </div>
  </div>
</template>

<script>
import profile from '../mixin/profile'

export default {
  mixins: [
    profile
  ],

  data () {
    return {
      employees: []
    }
  },

  methods: {
    show (employee) {
      const { username } = employee
      
      this.$progress.start()

      this.fetchProfile(username, () => {
        this.$store.dispatch('nav/navigate', {
          page: 'profile',
          identifier: username
        })

        this.$progress.done()
      })
    },

    fetchEmployees () {
      this.$http.get(BUNDY.apis.employee.list)
        .then(({ data: { employees } }) => {
          this.employees = employees
        })
        .catch(error => {
          console.log(error)
        })
    }
  },

  created () {
    this.fetchEmployees()
  }
}
</script>

