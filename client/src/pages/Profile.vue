<script setup>

    import { useAuthStore } from '@/stores/authStore'
    import { reactive, ref } from 'vue'
    import api from '@/axios'

    const passwordButtonLoading = ref(false)
    const authStore = useAuthStore()
    const passwordForm = reactive({
        currentPassword: null,
        newPassword: null,
        confirmPassword: null
    })

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
                            <v-text-field variant="solo-filled" label="Current password" v-model="passwordForm.currentPassword"></v-text-field>
                            <v-text-field variant="solo-filled" label="New password" v-model="passwordForm.newPassword"></v-text-field>
                            <v-text-field variant="solo-filled" label="Confirm password" v-model="passwordForm.confirmPassword"></v-text-field>
                        </v-card-item>
                        <v-card-actions>
                            <v-btn variant="flat" color="orange">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>