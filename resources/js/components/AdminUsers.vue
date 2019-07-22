<template>
  <div class="admin">
    <ct class="flex items-center">
      <span class="flex-1">Users</span>

      <div class="text-base">
        <button
          title="Add New User"
          class="text-blue-500 hover:text-blue-600"
          @click="addNew()"
        >
          <fa icon="user-plus" />
        </button>
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
          <div>Role: <span v-text="user.role.name" /></div>
          <div>Address: <span v-text="user.address" /></div>
          <div>Position: <span v-text="user.position" /></div>
          <div>Hired on: <span v-text="user.hired_on" /></div>
          <div>Level: <span v-text="user.level" /></div>
        </div>

        <drop-down
          :menu="dropDownMenu"
          @edit="edit(user)"
          class="absolute top-3 right-4"
        />

      </div>
    </paginator>

    <portal to="modal">
      <admin-user-form
        v-if="shown"
        :user="user"
        @close="close()"
        @success="success()"
      />
    </portal>
  </div>
</template>

<script>
import DropDown from './DropDown'
import Paginator from './Paginator'
import AdminUserForm from './AdminUserForm'

export default {
  components: {
    DropDown,
    Paginator,
    AdminUserForm
  },

  data () {
    return {
      user: null,
      shown: false,
    }
  },

  computed: {
    users () {
      return this.$store.getters['admin/user/pagination']
    },

    dropDownMenu () {
      return [
        ['edit', 'Edit'],
        ['reset', 'Reset Password'],
        ['suspend', 'Suspend'],
        ['delete', 'Delete'],
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
    },

    addNew () {
      this.toggleForm(true)
    },

    edit (user) {
      this.toggleForm(true, user)
    },

    toggleForm(shown, payload = null) {
      if (payload !== null) {
        const {
          id,
          email,
          role_id,
          last_name,
          first_name,
        } = payload

        this.user = {
          id,
          email,
          role_id,
          last_name,
          first_name
        }
      } else {
        this.user = null
      }

      this.shown = shown
    },

    close () {
      this.toggleForm(false)
    },

    success () {
      this.fetch()
      this.toggleForm(false)
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>