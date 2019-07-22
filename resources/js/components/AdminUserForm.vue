<template>
  <modal :enable-close-button="false">
    <error-manager
      :error="error"
      v-slot="{
        hasError,
        hasErrors,
        getErrorFor
      }"
    >
      <div class="bg-white w-screen h-screen relative z-20 shadow md:h-auto md:w-500">
        <ct>{{ title }}</ct>

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
            :label="buttonLabel"
            @click="save()"
            type="info"
          />
          <the-button
            @click="close()"
            label="Cancel"
          />
        </div>
      </div>
    </error-manager>
  </modal>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: null
    }
  },

  data () {
    return {
      error: null,
      form: this.parse()
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
    },

    creating () {
      return this.user === null
    },

    action () {
      return this.creating ? 'store' : 'update'
    },

    buttonLabel () {
      return this.creating ? 'Create' : 'Update'
    },

    title () {
      return this.creating ? 'New User' : `Update User`
    }
  },

  methods: {
    parse () {
      if (this.user === null) {
        return {
          email: '',
          role_id: 1,
          last_name: '',
          first_name: '',
        }
      }

      return this.user
    },

    save () {
      const payload = this.creating ? null : {id: this.user.id}
      this.$http.route(`admin.users.${this.action}`, payload)
        .post(this.form)
          .then(( { data: { message } }) => {
            this.$bus.emit('successful', { message })
            this.$emit('success')
          })
          .catch(error => {
            this.error = error.response.data
          })
    },

    close () {
      this.$emit('close')
    }
  }
}
</script>

