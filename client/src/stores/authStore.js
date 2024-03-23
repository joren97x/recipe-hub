import { defineStore } from "pinia"

export const useAuthStore = defineStore('auth', {
    state: () => ({
        auth: JSON.parse(localStorage.getItem('auth')),
        token: JSON.parse(localStorage.getItem('token')),
    }),
    getters: {
        getToken: (state) => {
            return state.token
        },
        isAuthenticated: (state) => {
            return state.auth
        }
    },
    actions: {
        setToken(token) {
            this.token = token
        },
        setAuth(auth) {
            this.auth = auth
        }
    }
})