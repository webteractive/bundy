<template>
  <div class="field">
    <label
      :for="name"
      v-text="label"
      v-if="label"
      class="block mb-1"
    />
    <div class="relative">
      <span
        v-text="icon"
        v-if="icon"
        class="absolute px-4 py-2"
      />
      <input
        v-if="inputTypes"
        :type="type"
        :class="{
          'pl-10': icon,
          'bg-red-100': withError
        }"
        :id="name"
        v-model="theValue"
        @input="input"
        @keyup.enter="$emit('enter')"
        class="border border-b-2 px-4 py-2 w-full rounded"
      />
      <bundy-select
        :options="selectOptions"
        v-else-if="type === 'select'"
        v-model="theValue"
        @input="input"
      >
      </bundy-select>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      default: ''
    },

    type: {
      type: String,
      default: 'text'
    },

    icon: {
      type: String,
      default: ''
    },

    label: {
      type: String,
      default: ''
    },

    withError: {
      type: Boolean,
      default: false
    },

    selectOptions: {
      type: Array,
      default: () => ([])
    }
  },

  data () {
    return {
      name: '',
      theValue: this.value
    }
  },

  computed: {
    inputTypes () {
      return [
        'text',
        'password',
        'email',
        'number'
      ].indexOf(this.type) > -1
    }
  },

  watch: {
    value (value) {
      this.theValue = value;
    }
  },

  methods: {
    input() {
      this.$emit('input', this.theValue);
    }
  },

  created () {
    this.name = `field-${this._uid}`
  }
}
</script>

