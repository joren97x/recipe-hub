<script setup>

    import { ref, onMounted, reactive } from 'vue'
    import api from '../axios'
    import { useAuthStore } from '../stores/authStore'
    import { formatDistance } from 'date-fns'

    const authStore = useAuthStore()
    const snackbar = ref(false)
    const recipes = ref(null)
    const editDialog = ref(false)
    const deleteDialog = ref(false)
    const createDialog = ref(false)
    const selectedRecipe = ref(null)
    const message = ref(null)
    const editButton = ref(false)
    const deleteButton = ref(false)
    const createButton = ref(false)
    const recipeForm = reactive({
        user_id: authStore.auth.id,
        name: null,
        description: null,
        image: null,
        ingredients: [''],
        methods: ['']
    })

    function createRecipe() {
        createButton.value = true
        api.post('/recipes', recipeForm, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            createButton.value = false
            getRecipes()
            createDialog.value = false
            recipeForm.name = null
            recipeForm.description = null
            recipeForm.image = null
            recipeForm.ingredients = ['']
            recipeForm.methods = ['']
            message.value = "Recipe created"
            snackbar.value = true
        })
        .catch((err) => {
            createButton.value = false
            console.error(err)
        })
    }

    function deleteRecipe() {
        deleteButton.value = true
        api.delete(`/recipes/${selectedRecipe.value.id}`, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            deleteButton.value = false
            deleteDialog.value = false
            message.value = "Recipe deleted"
            snackbar.value = true
            getRecipes()
        })
        .catch((err) => {
            deleteButton.value = false
            console.error(err)
        })
    }

    function updateRecipe() {
        editButton.value = true
        api.put(`/recipes/${selectedRecipe.value.id}`, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            editButton.value = false
            editDialog.value = false
            message.value = "Recipe updated"
            snackbar.value = true
            getRecipes()
            console.log(res)
        })
        .catch((err) => {
            editButton.value = false
            console.error(err)
        })
    }

    function handleFileChange(event) {
        const file = event.target.files[0]
        if (file) {
            recipeForm.image = file.name
        }
    }

    onMounted(() => {
        getRecipes()
    })

    function getRecipes() {
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
    }

</script>

<template>
    <v-container fluid>
        <v-container>
            <v-row>
                <p class="text-h4 mb-2">My recipes</p>
                <v-spacer/>
                <v-btn @click="createDialog = true" color="orange" class="text-white" prepend-icon="mdi-plus">Add recipe</v-btn>
            </v-row>
            
            <v-row v-if="recipes">
                
                <v-col cols="4" v-for="recipe in recipes" :key="recipe.id">
                    <v-card max-width="374">
                        <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" cover></v-img>
                    
                        <v-list-item>
                            {{ recipe.name }}
                            <template v-slot:append>
                                <v-tooltip text="Edit recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-square-edit-outline" @click="() => { editDialog = true; selectedRecipe = recipe }" v-bind="props" size="small" variant="text"></v-btn>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Delete recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-delete-outline" color="red" @click="() => { deleteDialog = true; selectedRecipe = recipe }" size="small" v-bind="props" variant="text"></v-btn>
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
            <v-row v-else>
                <v-col cols="4" v-for="n in 3" :key="n" >
                    <v-skeleton-loader type="image, table-tfoot, list-item-two-line, button"></v-skeleton-loader>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="editDialog">
            <v-card title="Edit recipe">
                <v-card-item>
                    {{ selectedRecipe }}
                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="editDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="orange" @click="updateRecipe()" :loading="editButton">Update</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="deleteDialog">
            <v-card title="Delete recipe">
                <v-card-item>
                    <v-alert :title="selectedRecipe.name">
                        <template v-slot:prepend>
                            <v-avatar color="grey" rounded="0"  size="150">
                                <v-img src="https://cdn.vuetifyjs.com/images/cards/cooking.png" cover></v-img>
                            </v-avatar>
                        </template>
                        <template v-slot:append>
                            <v-chip prepend-icon="mdi-heart">{{ selectedRecipe.likes }}</v-chip>
                            <v-chip prepend-icon="mdi-eye" class="ms-2">{{ selectedRecipe.views }}</v-chip>
                        </template>
                        {{ selectedRecipe.description }}
                    </v-alert>
                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="deleteDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="red" @click="deleteRecipe()" :loading="deleteButton">Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="createDialog">
            <v-card title="Create recipe">
                <v-card-item>
                    {{ recipeForm }}
                    <v-row>
                        <v-col cols="6">
                            <v-file-input label="Upload image..." @change="handleFileChange" variant="solo-filled"></v-file-input>
                            <div style="height: 400px; width: 100%" class="bg-grey"></div>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field variant="solo-filled" label="Name" v-model="recipeForm.name"></v-text-field>
                            <v-textarea variant="solo-filled" label="Description" rows="1" auto-grow v-model="recipeForm.description"></v-textarea>
                            <p>Ingredients</p>
                            <div v-for="(ingredient, index) in recipeForm.ingredients" :key="index">
                                <v-text-field label="Ingredient" variant="solo-filled" v-model="recipeForm.ingredients[index]"></v-text-field>
                            </div>
                            <v-btn prepend-icon="mdi-plus" block class="text-white" color="green-lighten-2" @click="recipeForm.ingredients.push('')">Add ingredient</v-btn>
                            <p>Methods</p>
                            <div v-for="(method, index) in recipeForm.methods" :key="index">
                                <v-text-field label="Method" variant="solo-filled" v-model="recipeForm.methods[index]"></v-text-field>
                            </div>
                            <v-btn prepend-icon="mdi-plus" block class="text-white" color="green-lighten-2" @click="recipeForm.methods.push('')">Add method</v-btn>
                        </v-col>
                    </v-row>
                </v-card-item>
                <v-card-actions class="my-3">
                    <v-spacer/>
                    <v-btn @click="createDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" color="orange" class="text-white" @click="createRecipe()" :loading="createButton">Create</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar">
            {{ message }}
        </v-snackbar>
    </v-container>
</template>