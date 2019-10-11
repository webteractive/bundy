<template>
  <modal
    v-if="shown"
    disable-close-button
  >
    <div class="bg-white w-screen h-screen md:w-500 md:h-auto relative z-20 shadow">
      <ct>Dispute</ct>
      <div class="px-4 pt-4 pb-2">
        <field-wrapper
          required
          label="Started At"
        >
          <input type="time" />
        </field-wrapper>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  data () {
    return {
      shown: false
    }
  },

  methods: {
    toggle (shown) {
      this.shown = shown
    },

    open ({ id, started_at, ended_at }) {
      console.log({id, started_at, ended_at});
      this.toggle(true)
    },

    close () {
      this.toggle(false)
    }
  },

  mounted () {
    this.$bus.on('timeLog.dispute', this.open)
  }
}
</script>