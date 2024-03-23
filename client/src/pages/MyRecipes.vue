<script setup>

    import { ref, onMounted } from 'vue'
    import api from '../axios'
    import { useAuthStore } from '../stores/authStore'
    import RecipeCard from '../components/RecipeCard.vue'
    import { formatDistance } from 'date-fns'

    const authStore = useAuthStore()
    const recipes = ref(null)
    const editDialog = ref(false)
    const deleteDialog = ref(false)
    const createDialog = ref(false)

    onMounted(() => {
        api.get(`/users/${authStore.auth.id}/recipes`, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        }).then((res) => {
            recipes.value = res.data
        })
        .catch((err) => {
            console.error(err)
        })
    })

</script>

<template>
    <v-container fluid>
        <v-container>
            <p class="text-h4 mb-2">My recipes</p>
            <v-btn @click="createDialog = true">Add recipe</v-btn>
            <v-row v-if="recipes">
                <v-col cols="4" v-for="recipe in recipes" :key="recipe.id">
                    <v-card max-width="374">
                        <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" cover></v-img>
                    
                        <v-list-item>
                            {{ recipe.name }}
                            <template v-slot:append>
                                <v-tooltip text="Edit recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-square-edit-outline" @click="editDialog = true" v-bind="props" size="small" variant="text"></v-btn>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Delete recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-delete-outline" color="red" @click="deleteDialog = true" size="small" v-bind="props" variant="text"></v-btn>
                                    </template>
                                </v-tooltip>
                            </template>
                        </v-list-item>
                    
                        <v-card-text>
                            {{ recipe.description }}
                            <div class="text-subtitle-1">
                                <v-icon>mdi-circle-small</v-icon> 
                                <span class="text-caption">  {{ formatDistance(new Date(recipe.created_at), new Date()) }} ago </span>
                            </div> 
                        </v-card-text>
                    
                        <v-divider class="mx-4 mb-1"></v-divider>

                        <v-card-actions>
                            <v-chip prepend-icon="mdi-heart">{{ recipe.likes }}</v-chip>
                            <v-chip prepend-icon="mdi-eye" class="ms-2">{{ recipe.views }}</v-chip>
                            <v-spacer/>
                            <v-btn color="orange" :to="`/recipes/${recipe.id}`">View recipe</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="editDialog">
            <v-card title="Edit recipe">
                <v-card-item>

                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="editDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="orange">Update</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="deleteDialog">
            <v-card title="Delete recipe">
                <v-card-item>
                    
                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="deleteDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="red">Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="createDialog">
            <v-card title="Create recipe">
                <v-card-item>
                    i add this shit tommorow i gtg sleep
                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="createDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="orange">Create</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>