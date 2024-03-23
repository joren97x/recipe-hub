<script setup>

    import Footer from './Footer.vue'
    import { useAuthStore } from '../stores/authStore.js'
    import { useRouter } from 'vue-router'

    const router = useRouter()
    const authStore = useAuthStore()

    function logout() {
        localStorage.removeItem('auth')
        localStorage.removeItem('token')
        authStore.token = localStorage.getItem('token')
        authStore.auth = localStorage.getItem('auth')
    }

</script>

<template>
    <div>
        <v-toolbar style="background-color: rgb(217, 237, 191);">
            <v-toolbar-title> 
                <router-link to="/" class="text-decoration-none font-weight-bold">Logo or some shit</router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field class="mt-6 me-4" variant="outlined" label="Search for recipes..." density="compact"></v-text-field>
            <v-btn class="text-grey-darken-2" to="/recipes"> Recipes </v-btn>
            <v-btn class="text-grey-darken-2" to="/about"> About </v-btn>
            <template v-if="!authStore.isAuthenticated">
                <v-btn class="text-grey-darken-2" to="/register"> Register </v-btn>
                <v-btn color="orange" class="text-white" variant="flat" to="/login"> Login </v-btn>
            </template>
            <template v-else>
                <v-btn class="text-grey-darken-2" to="/my-recipes"> My recipes </v-btn>
                <v-btn @click="logout()" prepend-icon="mdi-logout" color="red"> Logout </v-btn>
            </template>
        </v-toolbar>
        <v-main>
            <router-view></router-view>
        </v-main>
        <Footer/>
    </div>
        
</template>