<script setup>

    import { onMounted, ref } from 'vue'
    import api from '../axios.js'
    import { useAuthStore } from '../stores/authStore.js'
    import RecipeCard from '../components/RecipeCard.vue'

    const authStore = useAuthStore()
    const data = ref(null)
    onMounted(() => {
        api.get('/recipes')
        .then((res) => {
            data.value = res.data
        })
        .catch((err) => {
            console.log(err)
        })
    })

</script>

<template>
    <v-container fluid>
        <v-container>
            <v-row v-if="data">
                <v-col cols="4" v-for="recipe in data.recipes" :key="recipe.id">
                    <RecipeCard :recipe="recipe"/>
                </v-col>
            </v-row>
            <v-row v-else>
                <v-col cols="4" v-for="n in 6" :key="n" >
                    <v-skeleton-loader type="image, list-item-three-line, button, button"></v-skeleton-loader>
                </v-col>
            </v-row>
            <div style="height: 60vh" class="text-center text-grey-darken-2" v-if="data?.recipes.length == 0">
                <v-img src="https://fcbk.su/_data/stickers/bun/bun_05.png" style="margin-left: auto; margin-right: auto; margin-top: 10%;" height="100" width="100" cover></v-img>
                <p class="my-4 text-h3"> No recipes found </p>
                <p class="my-4 text-h6"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quos, omnis! </p>
            </div>
        </v-container>
    </v-container>
</template>

<style scoped>

    #linear {
        background: linear-gradient(to right, #FF9800, #2C7865);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #dumbass_div {
        height: 70vh;
        display: flex; 
        justify-content: center; 
        align-items: center;
    }

</style>