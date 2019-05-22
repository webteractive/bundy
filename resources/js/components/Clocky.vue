<template>
  <div
    :class="{
      'bg-black': isDarkMode(),
      'bg-gray-300': ! isDarkMode(),
    }"
    class="clocky relative rounded-full shadow-inner overflow-hidden"
  >
    <span class="dot absolute z-50 w-4 h-4 bg-red-700 rounded-full shadow-inner" />
    <span class="hand hours absolute bg-gray-800 z-20 rounded-full shadow-inner" :style="hrHand" />
    <span class="hand minutes absolute bg-gray-600 z-30 rounded-full shadow-inner" :style="minHand" />
    <span class="hand seconds absolute bg-red-700 z-40 rounded-full shadow-inner" :style="secHand" />
    <span
      :class="{
        'bg-gray-300 text-black': isDarkMode(),
        'bg-black text-white': ! isDarkMode(),
      }"
      v-text="showDisplay()"
      class="disp absolute z-10 px-2 rounded font-mono"
    />
  </div>
</template>

<script>
import format from 'date-fns/format'
import getHours from 'date-fns/get_hours'
import getMinutes from 'date-fns/get_minutes'
import getSeconds from 'date-fns/get_seconds'

export default {
  data () {
    return {
      tickId: null,
      hours: '45deg',
      minutes: '45deg',
      seconds: '0deg'
    }
  },

  computed: {
    hrHand () {
      return {
        transform: `rotate(${this.hours})`
      }
    },

    minHand () {
      return {
        transform: `rotate(${this.minutes})`
      }
    },

    secHand () {
      return {
        transform: `rotate(${this.seconds})`
      }
    }
  },

  methods: {
    tick () {
      const now = new Date()
      const hours = getHours(now)
      const minutes = getMinutes(now)
      const seconds = getSeconds(now)

      this.hours = `${30 * hours + 90}deg`
      this.minutes = `${(minutes / 60) * 360}deg`
      this.seconds = `${(seconds / 60) * 360}deg`
    },

    isDarkMode () {
      const hour24 = format(new Date(), 'H')
      return hour24 >= 18 && hour24 <= 24 || hour24 >= 1 && hour24 <= 5
    },

    showDisplay () {
      return format(new Date(), 'hh:mm A')
    }
  },

  mounted () {
    this.tickId =  setInterval(this.tick, 1000)
  },

  beforeDestroy () {
    clearInterval(this.tickId)
  }
}
</script>
