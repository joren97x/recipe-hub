<script setup>

    import { useAuthStore } from '@/stores/authStore'
    import { reactive, ref } from 'vue'
    import api from '@/axios'

    const passwordButtonLoading = ref(false)
    const authStore = useAuthStore()
    const snackbar = ref(false)
    const passwordForm = reactive({
        current_password: null,
        new_password: null,
        new_password_confirmation: null
    })

    function changePassword() {
        passwordButtonLoading.value = true
        api.put(`/change-password`, passwordForm, {
            headers: {
                Authorization: `Bearer ${authStore.getToken}`
            }
        })
        .then((res) => {
            passwordForm.current_password = null
            passwordForm.new_password = null
            passwordForm.new_password_confirmation = null
            snackbar.value = true
            passwordButtonLoading.value = false
            console.log(res)
        })
        .catch((err) => {
            passwordButtonLoading.value = false
            console.error(err)
        })
    }

</script>

<template>
    <v-container fluid>
        <v-container>
            <p class="text-h4 mb-2">Profile</p>
            <div class="my-5">
                <p>Name: {{ authStore.auth.name }}</p>
                <p>Email: {{ authStore.auth.email }}</p>
            </div>
            <v-row>
                <v-col cols="6">
                    <v-card title="Change password">
                        <v-card-item>
                            <v-text-field variant="solo-filled" label="Current password" v-model="passwordForm.current_password"></v-text-field>
                            <v-text-field variant="solo-filled" label="New password" v-model="passwordForm.new_password"></v-text-field>
                            <v-text-field variant="solo-filled" label="Confirm password" v-model="passwordForm.new_password_confirmation"></v-text-field>
                        </v-card-item>
                        <v-card-actions>
                            <v-btn variant="flat" color="orange" :loading="passwordButtonLoading" @click="changePassword()">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-snackbar v-model="snackbar">
            Password updated
        </v-snackbar>
    </v-container>
</template>