<script setup>

    import Footer from './Footer.vue'
    import { useAuthStore } from '../stores/authStore.js'
    import { useRouter } from 'vue-router'
    import { ref, watch } from 'vue'
    import api from '@/axios'

    const router = useRouter()
    const authStore = useAuthStore()
    const search = ref('')

    const items = ref([])

    watch(search, () => {
        if(search.value == ' ' || search.value == '') {
            items.value.splice(0, items.value.length)
        }
        else {
            api.get(`/search/${search.value}`)
            .then((res) => {
                console.log(res.data)
                items.value.splice(0, items.value.length)
                res.data.forEach((data) => {
                    items.value.push(data)
                })
            })
            .catch((err) => {
                console.error(err)
            })
        }
    })

    function logout() {
        localStorage.removeItem('auth')
        localStorage.removeItem('token')
        authStore.token = localStorage.getItem('token')
        authStore.auth = localStorage.getItem('auth')
        router.push('/login')
    }

</script>

<template>
    <div>
        <v-toolbar style="background-color: rgb(217, 237, 191);">
            <v-toolbar-title> 
                <router-link to="/" class="text-decoration-none text-h5 font-weight-bold">RECIPE HUB</router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field class="mt-6 me-4" v-model="search" variant="solo" label="Search for recipes..." density="compact">
                <v-menu activator="parent">
                    <v-list v-if="items">
                        <v-list-item v-for="item in items" :key="item.id" :to="`/recipes/${item.id}`">{{item.name}}</v-list-item>
                    </v-list>
                </v-menu>
            </v-text-field>
            <v-btn class="text-grey-darken-2" to="/recipes"> Recipes </v-btn>
            <v-btn class="text-grey-darken-2" to="/about"> About </v-btn>
            <template v-if="!authStore.isAuthenticated">
                <v-btn class="text-grey-darken-2" to="/register"> Register </v-btn>
                <v-btn color="orange" class="text-white" variant="flat" to="/login"> Login </v-btn>
            </template>
            <template v-else>
                <v-btn class="text-grey-darken-2" to="/my-recipes"> My recipes </v-btn>
                <v-btn class="text-grey-darken-2" to="/profile"> Profile </v-btn>
                <v-btn @click="logout()" prepend-icon="mdi-logout" color="red"> Logout </v-btn>
            </template>
        </v-toolbar>
        <v-main>
            <router-view></router-view>
        </v-main>
        <Footer/>
    </div>
        
</template>