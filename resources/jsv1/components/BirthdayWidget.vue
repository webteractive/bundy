<template>
  <div
    v-if="shouldGreetSomeone"
    class="min-h-32 bg-green-500 text-white mb-3"
  >
    <ct 
      :title="title"
      class="text-white border-green-600"
    />

    <div class="px-4 py-3">
      <div class="flex py-4 items-center justify-center">
        <div class="inline-flex items-center justify-center p-1 border-2 border-white">
          <user-photo
            :user="celebrant"
            bg-color="bg-white"
            class="text-green-500 text-5xl"
          />
        </div>
      </div>

      <p class="text-center text-xl leading-tight py-2 px-4 italic">
        {{ message }}
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  computed: {
    ...mapGetters({
      time: 'clock/time',
      user: 'user/details',
      celebrant: 'birthdayCelebrant'
    }),



    title () {
      return `Happy Birthday ${this.celebrant.first_name}!`
    },

    shouldGreetSomeone () {
      return this.celebrant !== null
    },

    message () {
      const messages = [
        'Wishing you the happiest of birthdays.',
        'Getting older sucks, but you make it look easy.',
        '<Generic birthday greeting here>',
        'Your birthday’s here! Another year! Have good cheer! Grab a beer!',
        'I hope everyone remembers your birthday, but forgets how old you are.',
        'Congratulations on another year on Earth.',
        '<Some awkward birthday greeting here>',
        'Have a great birthday, and remember to never act your age.',
        'Cheer up. Turning a year older is better than the alternative.'
      ];

      return messages[Math.floor(Math.random() * messages.length)]
    }
  }
}
</script>
