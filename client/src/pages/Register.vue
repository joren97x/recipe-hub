<script setup>

    import { reactive, ref } from 'vue'
    import { useAuthStore } from '../stores/authStore'
    import { useRouter } from 'vue-router'
    import api from '../axios'

    const router = useRouter()
    const authStore = useAuthStore()
    const showPassword = ref(false)
    const registerButtonLoading = ref(false)
    const form = reactive({
        email: null,
        name: null,
        password: null
    })

    function register() {
        try {
            registerButtonLoading.value = true
            api.post('/register', form).then((res) => {
                registerButtonLoading.value = true
                authStore.setAuth(res.data.user)
                authStore.setToken(res.data.token)
                localStorage.setItem('auth', JSON.stringify(res.data.user))
                localStorage.setItem('token', JSON.stringify(res.data.token))
                router.push('/')
            }).catch((err) => {
                registerButtonLoading.value = false
                console.error(err)
            })

        }
        catch(err) {
            registerButtonLoading.value = false
            console.error(err)
        }
    }


</script>

<template>
    <v-container fluid style="background-color: rgb(217, 237, 191)">
        <v-btn prepend-icon="mdi-arrow-left" variant="flat" class="text-white" color="orange" to="/">Go back</v-btn>
        <v-row justify="center">
            <v-col cols="6">
                <v-card>
                    <v-card-title>
                        Register
                    </v-card-title>
                    <v-card-item>
                        <v-text-field variant="solo-filled" label="Email" v-model="form.email"></v-text-field>
                        <v-text-field variant="solo-filled" label="Name" v-model="form.name"></v-text-field>
                        <v-text-field variant="solo-filled" :type="showPassword ? '' : 'password'" label="Password" v-model="form.password">
                            <template v-slot:append-inner>
                                <v-btn variant="text" :icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'" @click="showPassword = !showPassword"></v-btn>
                            </template>
                        </v-text-field>
                    </v-card-item>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn variant="flat" @click="register()" :loading="registerButtonLoading" block color="orange" class="text-white">Register</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn variant="text" to="/login" block color="orange" class="text-white">Login</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>