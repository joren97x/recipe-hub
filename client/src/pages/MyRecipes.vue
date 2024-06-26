<script setup>

    import { ref, onMounted, reactive } from 'vue'
    import api from '../axios'
    import { useAuthStore } from '../stores/authStore'
    import { formatDistance } from 'date-fns'

    const BASE_IMAGE_URL = process.env.VUE_APP_BASE_IMAGE_URL
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
    const fileImage = ref(null)
    const createRecipeErrors = ref(null)
    const editRecipeErrors = ref(null)
    const recipeForm = reactive({
        user_id: authStore.auth.id,
        name: null,
        description: null,
        image: null,
        ingredients: [''],
        methods: ['']
    })

    const updateRecipeForm = ref(null)

    function createRecipe() {
        createButton.value = true
        uploadFile(fileImage.value)
        api.post('/recipes', recipeForm, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            createRecipeErrors.value = null
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
            createRecipeErrors.value = err.response.data.errors
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
        uploadFile(fileImage.value)
        api.put(`/recipes/${updateRecipeForm.value.id}`, updateRecipeForm.value, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            editRecipeErrors.value = null
            editButton.value = false
            editDialog.value = false
            message.value = "Recipe updated"
            snackbar.value = true
            getRecipes()
            console.log(res)
        })
        .catch((err) => {
            editRecipeErrors.value = err.response.data.errors
            editButton.value = false
            console.error(err)
        })
    }

    function handleCreateFileChange(event) {
        const file = new FormData()
        file.append('file', event.target.files[0])
        fileImage.value = file
        recipeForm.image = event.target.files[0].name
    }

    function uploadFile(file) {
        api.post('/upload', file, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            console.log(res)
            fileImage.value = null
        })
        .catch((err) => {
            console.error(err)
        })
    }

    function handleEditFileChange(event) {
        const file = new FormData()
        file.append('file', event.target.files[0])
        fileImage.value = file
        updateRecipeForm.value.image = event.target.files[0].name
    }

    onMounted(() => {
        getRecipes()
    })

    function showEditDialog(recipe) {
        editDialog.value = true; 
        updateRecipeForm.value = recipe;
        updateRecipeForm.value.ingredients = JSON.parse(recipe.ingredients)
        updateRecipeForm.value.methods = JSON.parse(recipe.methods)
    }

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
                        <v-img height="250" :src="`${BASE_IMAGE_URL}/${recipe.image}`" cover></v-img>
                    
                        <v-list-item>
                            {{ recipe.name }}
                            <template v-slot:append>
                                <v-tooltip text="Edit recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-square-edit-outline" @click="showEditDialog(recipe)" v-bind="props" size="small" variant="text"></v-btn>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Delete recipe" location="top">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-delete-outline" color="red" @click="() => { deleteDialog = true; selectedRecipe = recipe; }" size="small" v-bind="props" variant="text"></v-btn>
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
            
            <p v-if="recipes?.length == 0" class="my-6"> You currently dont have any recipes lil bro </p>
        </v-container>
        <v-dialog v-model="editDialog">
            <v-card title="Edit recipe">
                <v-card-item>
                    {{ editRecipeErrors }}
                    <v-row>
                        <v-col cols="6">
                            <v-file-input label="Upload image..." @change="handleEditFileChange" variant="solo-filled" accept="image/*" counter show-size></v-file-input>
                            <v-img height="400" width="100%" :src="`${BASE_IMAGE_URL}/${updateRecipeForm.image}`" cover></v-img>
                        </v-col>
                        <v-col cols="6">

                            <v-text-field variant="solo-filled" label="Name" :error-messages="editRecipeErrors?.name" v-model="updateRecipeForm.name"></v-text-field>
                            <v-textarea variant="solo-filled" label="Description" :error-messages="editRecipeErrors?.description" rows="1" auto-grow v-model="updateRecipeForm.description"></v-textarea>
                            
                            <p>Ingredients</p>
                            <p class="text-caption text-error" v-if="editRecipeErrors?.ingredients">{{ editRecipeErrors?.ingredients }}</p>
                            <div v-for="(ingredient, index) in updateRecipeForm.ingredients" :key="index">
                                <v-text-field label="Ingredient" variant="solo-filled" v-model="updateRecipeForm.ingredients[index]"></v-text-field>
                            </div>
                            <v-btn prepend-icon="mdi-plus" block class="text-white" color="green-lighten-2" @click="updateRecipeForm.ingredients.push('')">Add ingredient</v-btn>
                            
                            <p>Methods</p>
                            <p class="text-caption text-error" v-if="editRecipeErrors?.methods">{{ editRecipeErrors?.methods }}</p>
                            <div v-for="(method, index) in updateRecipeForm.methods" :key="index">
                                <v-text-field label="Method" variant="solo-filled" v-model="updateRecipeForm.methods[index]"></v-text-field>
                            </div>
                            <v-btn prepend-icon="mdi-plus" block class="text-white" color="green-lighten-2" @click="updateRecipeForm.methods.push('')">Add method</v-btn>
                        
                        </v-col>
                    </v-row>
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
                                <v-img :src="`${BASE_IMAGE_URL}/${selectedRecipe.image}`" cover></v-img>
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
                    <v-row>
                        <v-col cols="6">
                            <v-file-input label="Upload image..." :error-messages="createRecipeErrors?.image" @change="handleCreateFileChange" variant="solo-filled" accept="image/*" counter show-size></v-file-input>
                            <div style="height: 400px; width: 100%" class="bg-grey"></div>
                        </v-col>
                        <v-col cols="6">

                            <v-text-field variant="solo-filled" label="Name" :error-messages="createRecipeErrors?.name" v-model="recipeForm.name"></v-text-field>
                            <v-textarea variant="solo-filled" label="Description" :error-messages="createRecipeErrors?.description" rows="1" auto-grow v-model="recipeForm.description"></v-textarea>

                            <p class="mb-3">Ingredients</p>
                            <p class="text-caption text-error" v-if="createRecipeErrors?.ingredients">{{ createRecipeErrors?.ingredients }}</p>
                            <div v-for="(ingredient, index) in recipeForm.ingredients" :key="index">
                                <v-text-field label="Ingredient" variant="solo-filled" v-model="recipeForm.ingredients[index]"></v-text-field>
                            </div>
                            <v-btn prepend-icon="mdi-plus" block class="text-white" color="green-lighten-2" @click="recipeForm.ingredients.push('')">Add ingredient</v-btn>
                            
                            <p class="my-3">Methods</p>
                            <p class="text-caption text-error" v-if="createRecipeErrors?.methods">{{ createRecipeErrors?.methods }}</p>
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