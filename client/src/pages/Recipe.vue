<script setup>

    import { useRoute, useRouter } from "vue-router"
    import { computed, onMounted, onUpdated, ref } from 'vue'
    import api from "../axios"
    import { format } from 'date-fns'
    import { useAuthStore } from "@/stores/authStore"

    const authStore = useAuthStore()
    const route = useRoute()
    const recipe = ref(null)
    const viewLikes = ref(false)
    const likeButton = ref(false)
    const router = useRouter()

    function like() {
        likeButton.value = true
        api.post(`/recipes/${recipe.value.id}/like`, {}, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            likeButton.value = false
            getRecipe()
        })
        .catch((err) => {
            likeButton.value = false
            console.error(err)
            if(err.response.status == 401) {
                router.push('/login')
            }
        })
    }

    const liked = computed(() => {
        return authStore.auth && recipe.value?.user_likes.find(like => like.user_id === authStore.auth.id)
    })

    onMounted(() => {
        getRecipe()
    })

    onUpdated(() => {
        console.log('update')
        getRecipe()
    })

    function getRecipe() {
        console.log(route.params)
        api.get(`/recipes/${route.params.id}`)
        .then((res) => {
            recipe.value = res.data
        }) 
        .catch((err) => {
            console.error(err)
        })
    }

</script>

<template>
    <v-container fluid>
        <v-container>
            <v-row>
                <v-col cols="6">
                    <v-img height="400" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" cover></v-img>
                    <v-row class="mt-4 me-2">
                            <v-list-item :subtitle="recipe ? format(recipe.created_at, 'PPPPp') : ''" title="Joren"></v-list-item>
                            <v-spacer/>
                            <v-chip prepend-icon="mdi-heart" @click="viewLikes = true">{{ recipe?.likes }}</v-chip>
                            <v-chip prepend-icon="mdi-eye" class="ms-2">{{ recipe?.views }}</v-chip>
                    </v-row>
                    
                </v-col>
                <v-col cols="6">
                    <v-card elevation="0">
                        <v-card-title>
                            <p class="text-h4 text-capitalize">{{ recipe?.name }}</p>
                        </v-card-title>
                        
                        <v-card-text class="text-subtitle-1">
                            {{ recipe?.description }}
                        </v-card-text>
                        <v-card-title>
                            <v-icon>mdi-fruit-cherries</v-icon> 
                            Ingredients
                        </v-card-title>
                        <v-card-text>
                            <v-list lines="one" v-if="recipe">
                                <v-list-item
                                    prepend-icon="mdi-circle-small"
                                    v-for="ingredient in JSON.parse(recipe.ingredients)"
                                    :key="ingredient"
                                    :title="ingredient"
                                ></v-list-item>
                            </v-list>
                        </v-card-text>
                        <v-card-title>
                            <v-icon>mdi-silverware-fork-knife</v-icon> 
                            Methods
                        </v-card-title>
                        <v-card-text>
                            <v-list lines="one" v-if="recipe">
                                <v-list-item
                                    prepend-icon="mdi-circle-small"
                                    v-for="method in JSON.parse(recipe.methods)"
                                    :key="method"
                                    :title="method"
                                ></v-list-item>
                            </v-list>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn :loading="likeButton" :prepend-icon="liked ? 'mdi-heart' : 'mdi-heart-outline'" variant="flat" @click="like()" color="orange">{{ liked ? 'Liked' : 'Like' }}</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="viewLikes"  width="50%">
            <v-card>
                <v-list-item>
                    <p>People who liked this</p>
                    <template v-slot:append>
                        <v-btn round variant="flat" icon="mdi-close" @click="viewLikes = false"></v-btn>
                    </template>
                </v-list-item>
                <v-card-item v-if="recipe" class="mb-4">
                    <p v-if="recipe.user_likes.length == 0"> sadly, no one liked this recipe :/</p>
                    <v-list>
                        <v-list-item append-icon="mdi-heart" :subtitle="format(like.created_at, 'PPPPp')" v-for="like in recipe.user_likes" :key="like.id" :title="like.user.name" >
                        </v-list-item>
                    </v-list>
                </v-card-item>
            </v-card>
        </v-dialog>
    </v-container>
</template>