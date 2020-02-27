<template>
  <widget>
    <div class="flex">
      <ct>Leaderboard</ct>
      <select>

      </select>
    </div>
    Leaderboard here
  </widget>
</template>

<script>
import flatpickr from 'flatpickr'

export default {
  computed: {
    months () {

    }
  },

  methods: {
    initDatePicker () {
      if (this.datePicker !== null) {
        this.datePicker.destroy()
      }

      this.datePicker = flatpickr(this.$refs.datePicker, {
        defaultDate: this.filterDate,
        onChange:  (selectedDates, dateStr, instance) => {
          this.jump(dateStr)
        }
      });
    }
  },

  created () {
    this.datePicker = null
  },

  mounted () {
    this.initDatePicker()
  }
}
</script>