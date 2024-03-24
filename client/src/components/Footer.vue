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
       Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque aspernatur quibusdam ipsum maxime voluptatum repudiandae voluptas! Ad exercitationem pariatur doloremque ipsam aut iusto magnam iste ratione veritatis! Optio repellendus cum animi minus ipsa tempore cupiditate, unde eos a eum rerum totam. Suscipit saepe consectetur laboriosam voluptates omnis cupiditate excepturi optio.
    </div>

    <v-divider></v-divider>

    <div>
      {{ new Date().getFullYear() }} — <strong>I cant think of a system name bruh</strong>
    </div>
  </v-footer>
</template>