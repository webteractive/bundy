<template>
  <on-click-outside :do="hide">
    <div :id="id">
      <button
        :class="{
          'text-blue-500 hover:text-blue-500': shown
        }"
        @click="toggle()"
        class="text-lg text-gray-400 hover:text-blue-400"
      >
        <fa icon="angle-down" />
      </button>
      <div
        v-if="shown"
        class="absolute right-0 top-6 w-240 py-2 bg-white shadow z-30"
      >
        <a
          v-for="[name, label] in menu"
          :key="name"
          v-text="label"
          @click.prevent="click({name, label})"
          class="block px-2 py-1 cursor-pointer hover:bg-blue-100 hover:text-blue-800"
        />
      </div>
    </div>
  </on-click-outside>
</template>

<script>
export default {
  props: {
    menu: {
      type: Array,
      default: () => ([])
    }
  },

  data () {
    return {
      shown: false
    }
  },

  computed: {
    id () {
      return `dropdown-menu-${this._uid}`;
    }
  },

  methods: {
    toggle () {
      this.shown = ! this.shown
      this.$bus.emit('dropdown.hideOthers', this.id)
    },

    hide () {
      this.shown = false
    },

    click (payload) {
      const { name } = payload
      this.$emit(name, payload)
      this.hide()
    },

    hideOthers (opened) {
      if (opened !== this.id && this.shown) {
        this.hide();
      }
    }
  },

  mounted () {
    this.$bus.on('dropdown.hideOthers', this.hideOthers);
  }
}
</script>

