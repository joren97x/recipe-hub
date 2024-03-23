import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const routes = [
	{
		path: '/',
		component: () => import('../components/Layout.vue'),
        children: [
            { 
                path: '', 
                component: () => import('../pages/Home.vue') 
            },
            { 
                path: 'recipes', 
                component: () => import('../pages/Recipes.vue'),
            },
            { 
                path: 'recipes/:id', 
                component: () => import('../pages/Recipe.vue'),
            },
            { 
                path: 'my-recipes', 
                component: () => import('../pages/MyRecipes.vue'),
            },
            { 
                path: 'about', 
                component: () => import('../pages/About.vue') 
            },
        ]
	},
	{
		path: '/login',
		name: 'login',
		component: () => import('../pages/Login.vue')
	},
	{
		path: '/register',
		name: 'register',
		component: () => import('../pages/Register.vue')
	},
]

const router = createRouter({
	history: createWebHistory(),
	routes
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if(!authStore.isAuthenticated) {
            next('/login')
        }
        else {
            next()
        }
    }
    else {
        if(authStore.isAuthenticated && (to.path == '/login' || to.path == '/register')) {
            next('/')
        }
        else {
            next()
        }
    }

})

export default router