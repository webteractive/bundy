<template>
  <div
    v-text="initials"
    class="inline-flex items-center justify-center w-24 h-24 border border-b-4 font-thin rounded-full text-5xl tracking-widest"
    :class="theme"
  />
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

String.prototype.capitalize = function(){
  return this.toLowerCase().replace( /\b\w/g, function (m) {
    return m.toUpperCase();
  });
};

export default {
  computed: {
    initials () {
      return this.$store.getters['user/details'].name.getInitials()
    },

    theme () {
      const options = [
        ['bg-white', 'text-gray-700', 'border-gray-300'],
        ['bg-black', 'text-white', 'border-gray-900'],
        ['bg-teal-500', 'text-teal-100', 'border-teal-500'],
        ['bg-green-600', 'text-green-100', 'border-green-700'],
        ['bg-gray-800', 'text-gray-100', 'border-gray-900'],
        ['bg-red-800', 'text-gray-100', 'border-red-900'],
        ['bg-blue-500', 'text-white', 'border-blue-600'],
        ['bg-blue-800', 'text-blue-100', 'border-blue-900'],
      ]

      return options[Math.floor(Math.random() * options.length)]
    }
  },
}
</script>
