<template>
  <div
    v-if="true" 
    class="bg-white"
  >
    <ct>Present</ct>
    <div class="flex flex-wrap p-4">
      <user-photo
        v-for="employee in employees"
        :user="employee"
        :key="employee.id"
        :title="employee.name"
        @click.native="showProfile(employee)"
        size="12"
        class="z-auto text-xl h-8 h-8 mr-1 mb-1 border border-white cursor-pointer relative hover:border-green-500"
      >
        <span
          slot="extra"
          class="absolute h-4 w-4 top-0 -mt-1 -mr-1 right-0 bg-gray-400 border-2 border-white"
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
      employees: [],
      online: []
    }
  },

  methods: {
    fetchPresent () {
      this.$http.route('presence').get()
        .then(({ data }) => {
          this.employees = data.map(item => item.user)
        })
    }
  },

  created () {
    this.fetchPresent()
    // this.$echo.join(`employee.${this.user.id}`)
    //     .here((users) => {
    //       console.log(users)
    //     })
    //     .joining((user) => {
    //         console.log(user.name);
    //     })
    //     .leaving((user) => {
    //         console.log(user.name);
    //     });
  }
}
</script>

