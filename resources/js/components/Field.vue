<template>
  <div class="field">
    <slot name="label">
      <label
        v-if="label"
        :for="name"
        class="label font-bold"
      >
        <span v-text="label" />
        <span
          v-if="required"
          v-text="`*`"
          class="text-red-500"
        />
      </label>
    </slot>

    <slot name="instruction">
      <p v-if="instruction" v-html="instruction" class="text-xs mb-1 italic text-gray-700" />
    </slot>

    <div class="relative">
      <span
        v-if="icon"
        v-text="icon"
        class="icon"
      />

      <input
        v-if="inputTypes"
        :id="name"
        :type="type"
        :class="[
          fieldClass,
          {
            'has-icon': icon,
            'has-error': hasError
          }
        ]"
        :disabled="disabled"
        :placeholder="placeholder"
        v-model="theValue"
        @input="input"
        @keyup.enter="$emit('enter')"
      />

      <div 
        v-else-if="type === 'date' || type === 'dates'"
        class="relative"
      >
        <input
          :id="name"
          :class="[
            fieldClass,
            'pr-10',
            {
              'has-icon': icon,
              'has-error': hasError
            }
          ]"
          :disabled="disabled"
          :placeholder="placeholder"
          v-model="theValue"
          @input="input"
          @keyup.enter="$emit('enter')"
          type="text"
          ref="datesField"
        />

        <span class="absolute right-0 top-0 bottom-0 flex items-center px-4 text-gray-500 text-xl">
          <fa icon="calendar" />
        </span>
      </div>

      <textarea
        v-else-if="type === 'textarea'"
        :id="name"
        :placeholder="placeholder"
        :class="[
          fieldClass,
          {
            'has-error': hasError
          }
        ]"
        :disabled="disabled"
        v-model="theValue"
        @input="input"
        @keyup.enter="$emit('enter')"
      />

      <bundy-select
        v-else-if="type === 'select'"
        :id="name"
        :disabled="disabled"
        :options="selectOptions"
        :class="[
          fieldClass,
          {
            'has-error': hasError
          }
        ]"
        v-model="theValue"
        @input="input"
      />

      <items-field
        v-else-if="type === 'items'"
        :id="name"
        :disabled="disabled"
        :placeholder="placeholder"
        :class="[
          fieldClass,
          {
            'has-error': hasError
          }
        ]"
        v-model="theValue"
      />

      <p
        v-for="error in errors"
        :key="error"
        v-html="error"
        class="text-sm text-red-700 italic"
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

    hasError: {
      type: Boolean,
      default: false
    },

    errors: {
      type: Array,
      default: () => ([])
    },

    selectOptions: {
      type: Array,
      default: () => ([])
    },

    placeholder: {
      type: String,
      default: ''
    },

    required: {
      type: Boolean,
      default: false
    },

    fieldClass: {
      type: String,
      default: ''
    },

    disabled: {
      type: Boolean,
      default: false
    },

    instruction: {
      type: String,
      default: ''
    },

    dateFieldSettings: {
      default: () => ({
        mode: 'range',
        minDate: 'today'
      })
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
    },

    initDatesField () {
      if (this.datesField !== null) {
        this.datesField.destroy()
      }

      if (this.$refs.datesField) {
        this.datesField = flatpickr(this.$refs.datesField, this.dateFieldSettings);
      }
    }
  },

  created () {
    if (this.type === 'dates' || this.type === 'date') {
      this.datesField = null
    }

    this.name = `field-${this._uid}`
  },

  mounted () {
    if (this.type === 'dates' || this.type === 'date') {
      this.initDatesField()
    }
  }
}
</script>

