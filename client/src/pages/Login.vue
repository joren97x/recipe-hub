<script setup>

    import { reactive, ref } from 'vue'
    import api from '../axios.js'
    import { useAuthStore } from '../stores/authStore.js'
    import { useRouter } from 'vue-router'

    const router = useRouter()
    const authStore = useAuthStore()
    const loginButtonLoading = ref(false)
    const showPassword = ref(false)
    const form = reactive({
        email: null,
        password: null
    })
    const errors = ref(null)

    function login() {
        try {
            loginButtonLoading.value = true
            api.post('/login', form)
            .then((res) => {
                loginButtonLoading.value = true
                authStore.setAuth(res.data)
                // authStore.setUser(res.data.user)
                // authStore.setToken(res.data.token)
                // localStorage.setItem('auth', JSON.stringify(res.data.user))
                // localStorage.setItem('token', JSON.stringify(res.data.token))
                router.push('/')
            }).catch((err) => {
                loginButtonLoading.value = false
                console.error(err)
                if(err.response) {
                    errors.value = err.response.data.errors
                    if(!err.response.data.errors) {
                        errors.value = { email: 'Invalid credentials' }
                    }
                }
                else {
                    errors.value = { server: 'Internal server error' }
                }
            })

        }
        catch(err) {
            loginButtonLoading.value = false
            console.error(err)
            errors.value = err.response.data.message
        }
    }

</script>

<template>
    <v-container fluid style="background-color: rgb(217, 237, 191); height: 100vh">
        <v-btn prepend-icon="mdi-arrow-left" variant="flat" class="text-white" color="orange" to="/">Go back</v-btn>
        <v-row justify="center">
            <v-col cols="6" class="mx-6">
                <v-card >
                    <v-card-title>
                        Login
                    </v-card-title>
                    <v-card-item>
                        <v-alert class="mb-3" v-if="errors?.server" :title="errors.server" icon="mdi-alert" color="red-lighten-2">
                            Did you turn on xampp lil bro?
                        </v-alert>
                        <v-text-field variant="solo-filled" :error-messages="errors?.email" label="Email" v-model="form.email"></v-text-field>
                        <v-text-field variant="solo-filled" :error-messages="errors?.password" :type="showPassword ? '' : 'password'" label="Password" v-model="form.password">
                            <template v-slot:append-inner>
                                <v-btn variant="text" :icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'" @click="showPassword = !showPassword"></v-btn>
                            </template>
                        </v-text-field>
                    </v-card-item>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn variant="flat" :loading="loginButtonLoading" @click="login"  block color="orange" class="text-white">Login</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn variant="text" to="/register" block color="orange" class="text-white">Register</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>