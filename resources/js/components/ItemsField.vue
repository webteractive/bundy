<template>
  <div class="relative px-3 py-2 bg-gray-200 border-b border-gray-400">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="flex"
    >
      <input
        :disabled="disabled"
        v-model="items[index]"
        @input="edit()"
        @keyup.enter="focusEntryField()"
        class="block w-full bg-transparent flex-1"
      />
      <span
        @click="trash(index)"
        class="cursor-pointer text-gray-500 hover:text-red-500"
      >
        <fa icon="trash" />
      </span>
    </div>
    <input
      :id="id"
      :disabled="disabled"
      :placeholder="placeholder"
      v-model="entry"
      ref="entryField"
      class="block bg-transparent w-full mt-1"
      @keyup.enter="enter()"
    />
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      default: ''
    },

    value: {
      type: Array,
      default: () => ([])
    },

    placeholder: {
      type: String,
      default: ''
    },
    
    disabled: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      entry: '',
      items: this.value
    }
  },

  methods: {
    enter () {
      this.items.push(this.entry)
      this.entry = ''
      this.$emit('input', this.items)
    },

    edit () {
      this.$emit('input', this.items)
    },

    trash (index) {
      this.items.splice(index, 1)
      this.$emit('input', this.items)
    },

    focusEntryField () {
      this.$refs.entryField.focus()
    }
  }
}
</script>
