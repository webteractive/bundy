<template>
  <div class="admin">
    <ct class="flex items-center">
      <span class="flex-1">Employees</span>

      <div class="text-base">
        <button 
          type="button"
          title="Add New Employee"
          class="text-blue-500 hover:text-blue-600"
        >
          <fa icon="user-plus" />
        </button>
      </div>
    </ct>

    <paginator
      :payload="employees"
      v-slot="{ items, pagination }"
    >
      <div
        v-for="employee in items"
        :key="employee.id"
        class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100"
      >
        <user-photo :user="employee" class="absolute left-4 top-4 text-2xl" />

        <h3 class="flex items-center mb-2">
          <warp
            :payload="employee"
            :label="employee.name"
            :to="['profile', employee.username]"
            :title="`Warp to ${employee.first_name}'s profile`"
            class="font-bold cursor-pointer hover:underline"
          />

          <span
            v-text="`@${employee.username}`"
            class="text-sm text-gray-500 ml-1"
          />

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="employee.created_at"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />
        </h3>
        <div>
          <div>Email: <span v-text="employee.email" /></div>
          <div>Address: <span v-text="employee.address" /></div>
          <div>Position: <span v-text="employee.position" /></div>
          <div>Level: <span v-text="employee.level" /></div>
        </div>
        <bio :bio="employee.bio" />

        <drop-down
          :menu="dropDownMenu"
          class="absolute top-3 right-4"
        />

      </div>
    </paginator>
  </div>
</template>

<script>
import Bio from './Bio'
import DropDown from './DropDown'
import Paginator from './Paginator'

export default {
  components: {
    Bio,
    DropDown,
    Paginator
  },

  computed: {
    employees () {
      return this.$store.getters['admin/employee/pagination']
    },

    dropDownMenu () {
      return [
        ['reset', 'Reset Password'],
        ['suspend', 'Suspend'],
        ['delete', 'Delete']
      ]
    }
  },

  methods: {
    fetch () {
      this.$http.route('employees')
        .get()
          .then(({ data }) => {
            this.$store.dispatch('admin/employee/paginate', data)
          })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

