<template>
  <div class="field">
    <slot name="label">
      <label
        :for="name"
        v-text="label"
        v-if="label"
        class="block mb-1"
      />
    </slot>
    <div class="relative">
      <span
        v-text="icon"
        v-if="icon"
        class="absolute px-4 py-2"
      />

      <input
        v-if="inputTypes"
        :id="name"
        :type="type"
        :class="{
          'pl-10': icon,
          'bg-red-100': withError
        }"
        :placeholder="placeholder"
        v-model="theValue"
        @input="input"
        @keyup.enter="$emit('enter')"
        class="border-b-2 px-4 py-2 w-full bg-gray-200 focus:bg-gray-300 focus:border-gray-400"
      />

      <textarea
        v-else-if="type === 'textarea'"
        :placeholder="placeholder"
        v-model="theValue"
        @input="input"
        @keyup.enter="$emit('enter')"
        class="border-b-2 px-4 py-2 w-full bg-gray-200 focus:bg-gray-300 focus:border-gray-400"
      />

      <bundy-select
        v-else-if="type === 'select'"
        :options="selectOptions"
        v-model="theValue"
        @input="input"
      />

      <items-field
        v-else-if="type === 'items'"
        :placeholder="placeholder"
        v-model="theValue"
        id="yesterday"
      />
    </div>
  </div>
</template>

<script>
import ItemsField from './ItemsField'

export default {
  props: {
    value: {},

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
    },

    placeholder: {
      type: String,
      default: ''
    }
  },

  components: {
    ItemsField
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

