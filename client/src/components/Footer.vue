<script setup>

    const icons = [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ]

</script>

<template>
    <v-footer
    style="background-color: rgb(217, 237, 191);"
    class="text-center pb-6 d-flex flex-column"
  >
    <div>
      <v-btn
        v-for="icon in icons"
        :key="icon"
        :icon="icon"
        class="mx-4"
        variant="text"
      ></v-btn>
    </div>

    <div class="pt-0">
        True story. As I walked inside sports complex, 37 women rushed to me and pulled
         their pants off tryna flash me their Coochie. I replied sternly “Haram”. All 37 women were 
         so shook all their clothes came off in a swift attack caused my aura. My friend who watches 
         Jujutsu Kaisen did not accept this tomfoolery and unsheathed his domain "Domain Expansion: Malevolent Kitchen" and cut them 
         into pieces causing a crimson rainfall reminiscent of your mother's period once a month(mura ug sukuna ba). Dare 
         I say, it was a bloody good day.
    </div>

    <v-divider></v-divider>

    <div>
      {{ new Date().getFullYear() }} — <strong>I cant think of a system name bruh</strong>
    </div>
  </v-footer>
</template>