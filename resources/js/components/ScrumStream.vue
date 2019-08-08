<template>
  <stream-layout>
    <user-photo
      :user="content.user"
      size="smaller"
      class="absolute left-4 top-4 text-2xl"
    />

    <stream-head :content="content" />

    <scrum-message :scrum="content" />

    <drop-down
      :menu="menu"
      class="absolute right-4 top-3 z-20"
    />
  </stream-layout>
</template>

<script>
import DropDown from './DropDown'
import StreamItem from './StreamItem'
import ScrumMessage from './ScrumMessage'

export default {
  extends: StreamItem,

  components: {
    DropDown,
    ScrumMessage
  },

  computed: {
    menu () {
      return [
        ['edit', 'Edit'],
        ['delete', 'Delete']
      ]
    },
  }
}
</script>
