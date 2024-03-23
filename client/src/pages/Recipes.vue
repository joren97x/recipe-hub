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
    <v-container fluid style="background-color: rgb(255,240,233);">
        <v-container>
            <v-row  v-if="data">
                <v-col cols="4" v-for="recipe in data.recipes" :key="recipe.id">
                    <RecipeCard :recipe="recipe"/>
                </v-col>
            </v-row>
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