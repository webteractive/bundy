<template>
  <div
    :class="[`h-${size}`, `w-${size}`, `bg-${backgroundColor}-600`]"
    class="rounded-full shadow-inner flex items-center justify-center font-thin"
  >
    <span
      v-for="letter in initials"
      :key="letter"
      v-text="letter"
      class="uppercase tracking-wide text-white"
    />
  </div>
</template>

<script>
String.prototype.getInitials = function(glue){
  if (typeof glue == "undefined") {
    var glue = true;
  }

  let initials = this.replace(/[^a-zA-Z- ]/g, "").match(/\b\w/g);
  
  if (glue) {
    return initials.join('');
  }

  return  initials;
};

export default {
  props: {
    size: {
      default: 16
    },

    user: {
      required: true
    }
  },

  computed: {
    backgroundColor () {
      const colors = [
        'blue', 'red', 'yellow', 'pink', 'indigo', 'purple', 'gray'
      ]

      return colors[Math.floor(Math.random() * colors.length)];
    },
    
    initials () {
      return this.user.name.getInitials()
    },
  }
}
</script>

