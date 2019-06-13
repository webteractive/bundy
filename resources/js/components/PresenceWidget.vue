<template>
  <div class="bg-white">
    <ct>Present</ct>
    <fetcher
      api="employee.list"
      v-slot="{ result }"
    >
      <div class="flex justify-center flex-wrap p-4" v-if="result">
        <user-photo
          v-for="employee in result.employees"
          :key="employee.id"
          :title="employee.name"
          @click.native="show(employee)"
          size="12"
          class="z-auto h-8 h-8 mr-1 mb-1 border border-transparent cursor-pointer hover:border-gray-600"
        />
      </div>
    </fetcher>
  </div>
</template>

<script>
import profile from '../mixin/profile'

export default {
  mixins: [
    profile
  ],

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
    }
  }
}
</script>

