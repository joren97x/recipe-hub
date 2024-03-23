<script setup>

    import { useRoute } from "vue-router"
    import { onMounted, ref } from 'vue'
    import api from "../axios"
    import { format } from 'date-fns'

    const route = useRoute()
    const recipe = ref(null)
    onMounted(() => {
        api.get(`/recipes/${route.params.id}`).then((res) => {
            recipe.value = res.data
        }) 
        .catch((err) => {
            console.error(err)
        })
    })

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
                            <v-chip prepend-icon="mdi-heart">{{ recipe?.likes }}</v-chip>
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
                            <v-btn prepend-icon="mdi-heart" variant="flat" color="orange">Like</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>