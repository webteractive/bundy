<template>
  <div class="admin">
    <ct class="flex items-center">
      <span class="flex-1">Users</span>

      <div class="text-base">
        <warp
          :to="['admin', 'users', 'new']"
          title="Add New User"
          class="text-blue-500 hover:text-blue-600"
        >
          <fa icon="user-plus" />
        </warp>
      </div>
    </ct>

    <paginator
      :payload="users"
      v-slot="{ items, pagination }"
    >
      <div
        v-for="user in items"
        :key="user.id"
        class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100"
      >
        <user-photo :user="user" class="absolute left-4 top-4 text-2xl" />

        <h3 class="flex items-center mb-2">
          <warp
            :payload="user"
            :label="user.name"
            :to="['profile', user.username]"
            :title="`Warp to ${user.first_name}'s profile`"
            class="font-bold cursor-pointer hover:underline"
          />

          <span
            v-text="`@${user.username}`"
            class="text-sm text-gray-500 ml-1"
          />

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="user.created_at"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />
        </h3>
        <div>
          <div>Email: <span v-text="user.email" /></div>
          <div>Address: <span v-text="user.address" /></div>
          <div>Position: <span v-text="user.position" /></div>
          <div>Hired on: <span v-text="user.hired_on" /></div>
          <div>Level: <span v-text="user.level" /></div>
        </div>
        <bio :bio="user.bio" />

        <drop-down
          :menu="dropDownMenu"
          class="absolute top-3 right-4"
        />

      </div>
    </paginator>

    <portal to="modal">
      <admin-user-form />
    </portal>
  </div>
</template>

<script>
import Bio from './Bio'
import DropDown from './DropDown'
import Paginator from './Paginator'
import AdminUserForm from './AdminUserForm'

export default {
  components: {
    Bio,
    DropDown,
    Paginator,
    AdminUserForm
  },

  computed: {
    users () {
      return this.$store.getters['admin/user/pagination']
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
      this.$http.route('admin.users')
        .get()
          .then(({ data }) => {
            this.$store.dispatch('admin/user/paginate', data)
          })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>