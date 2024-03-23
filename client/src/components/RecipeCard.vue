<script setup>

    defineProps({ recipe: Number})
    import { formatDistance } from 'date-fns'

</script>

<template>
    <v-card max-width="374">
        <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" cover></v-img>
    
        <v-card-item>
            <v-card-title>{{ recipe.name }}</v-card-title>
            <div class="text-subtitle-1">
                {{ recipe.user.name }} 
                <v-icon>mdi-circle-small</v-icon> 
                <span class="text-caption">  {{ formatDistance(new Date(recipe.created_at), new Date()) }} ago </span>
            </div> 
        </v-card-item>
    
        <v-card-text>
            {{ recipe.description }}
        </v-card-text>
    
        <v-divider class="mx-4 mb-1"></v-divider>

        <v-card-actions>
            <v-chip prepend-icon="mdi-heart">{{ recipe.likes }}</v-chip>
            <v-chip prepend-icon="mdi-eye" class="ms-2">{{ recipe.views }}</v-chip>
            <v-spacer/>
            <v-btn color="orange" :to="`/recipes/${recipe.id}`">View recipe</v-btn>
        </v-card-actions>
    </v-card>
  </template>