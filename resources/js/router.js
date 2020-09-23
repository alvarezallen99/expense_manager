import Vue from 'vue';
import VueRouter from 'vue-router';
import * as wfunctions from './src/plugins/functions.js' // Import all export functions

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            // =============================================================================
            // SINGLE PAGE LAYOUTS
            // =============================================================================
            path: '',
            component: () => import('@/layouts/main/Main.vue'),
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/views/Dashboard.vue'),
                    meta: {
                        role: 'user',
                        authRequired: true
                    }
                },
                {
                    path: '/roles',
                    name: 'roles',
                    component: () => import('@/views/Roles.vue'),
                    meta: {
                        role: 'admin',
                        authRequired: true
                    }
                },
                {
                    path: '/users',
                    name: 'users',
                    component: () => import('@/views/Users.vue'),
                    meta: {
                        role: 'admin',
                        authRequired: true
                    }
                },
                {
                    path: '/expense_categories',
                    name: 'expense_categories',
                    component: () => import('@/views/ExpenseCategories.vue'),
                    meta: {
                        role: 'admin',
                        authRequired: true
                    }
                },
                {
                    path: '/expenses',
                    name: 'expenses',
                    component: () => import('@/views/Expenses.vue'),
                    meta: {
                        role: 'user',
                        authRequired: true
                    }
                },
                {
                    path: '/change_password',
                    name: 'change_password',
                    component: () => import('@/views/ChangePassword.vue'),
                    meta: {
                        role: 'user',
                        authRequired: true
                    }
                },
            ]
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: '',
            component: () => import('@/layouts/full-page/FullPage.vue'),
            children: [
                {
                    path: '/login',
                    name: 'login',
                    component: () => import('@/views/pages/Login.vue'),
                    meta: {
                        role: 'user',
                        authRequired: false
                    }
                },
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: '*',
            redirect: '/'
        }
    ]
})

router.beforeEach((to, from, next) => {

    if(
        to.path == "/login" && wfunctions.Authenticated()
    ) {
        return router.push("/").catch(()=>{});
    }

    // If auth required, check login. If login fails redirect to login page
    if (to.meta.authRequired) {
        if (!(wfunctions.Authenticated())) {
            if(from.path == "/login"){
                return
            }
            return router.push('/login').catch(()=>{});
        }
    }

    try {
        if (to.meta.role == 'admin' && !wfunctions.IsAdmin()) {
            return router.push("/").catch(()=>{});
        }
    }catch (e) 
    {

    }
    
    
    return next()
})

export default router;
