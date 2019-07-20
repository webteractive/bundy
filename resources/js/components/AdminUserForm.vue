<template>
  <modal>
    <error-manager
      :error="error"
      v-slot="{
        hasError,
        hasErrors,
        getErrorFor
      }"
    >
      <div class="bg-white w-screen h-screen relative z-20 shadow md:h-auto md:w-500">
        <ct>New User</ct>

        <div class="px-4 pt-3 pb-4">
          <field
            :has-error="hasError('first_name')"
            :errors="getErrorFor('first_name')"
            v-model="form.first_name"
            required
            type="text"
            class="mb-4"
            label="First Name"
          />

          <field
            :has-error="hasError('last_name')"
            :errors="getErrorFor('last_name')"
            v-model="form.last_name"
            required
            type="text"
            class="mb-4"
            label="Last Name"
          />

          <field
            :select-options="roles"
            :has-error="hasError('role_id')"
            :errors="getErrorFor('role_id')"
            required
            v-model="form.role_id"
            label="Role"
            type="select"
            class="mb-4"
          />

          <field
            :has-error="hasError('email')"
            :errors="getErrorFor('email')"
            v-model="form.email"
            required
            type="email"
            label="Email"
          />
        </div>

        <div class="px-4 py-3 border-t">
          <the-button
            @click="create()"
            type="info"
            label="Create"
          />
        </div>
      </div>
    </error-manager>
  </modal>
</template>

<script>
export default {
  data () {
    return {
      error: null,
      form: {
        email: '',
        role_id: 1,
        last_name: '',
        first_name: '',
      }
    }
  },

  computed: {
    roles () {
      return this.$store.getters.roles.map(role => {
        return {
          value: role.id,
          text: role.name
        }
      })
    }
  },

  methods: {
    create () {
      this.$http.route('admin.users.store')
        .post(this.form)
          .then(( { data }) => {
            this.$bus.emit('successful', { message })
          })
          .catch(error => {
            this.error = error.response.data
          })
    }
  }
}
</script>

