/**
 * MY PLUGINS FUNCTIONS
 */
import * as wfunctions from './functions.js' // Import all export functions
const myPlugins = {
    install(Vue){

        Vue.mixin({
            data:()=>({
                url: process.env.MIX_APP_URL, // access .env file "VUE_APP_URL" w/c is url to server side script
                app_name: process.env.MIX_APP_NAME
            }),
            methods:{
                setToken(str) {
                    Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${str}`
                },
                parseJson(str) {
                    return wfunctions.IsJsonString(str) ? JSON.parse(str) : 'Invalid JSON Data'
                },
                getSecureLocalStorage(){
                    try{
                        var local = decrypt(localStorage.getItem('user'))
                        local = wfunctions.IsJsonString(local) ? JSON.parse(local) : null
                        local == null ? localStorage.removeItem('user') : local
                        return local
                    }catch(e){
                        localStorage.removeItem('user')
                        return ''
                    }
                },
                Logout(){
                    localStorage.removeItem('user')
                },
                errorResponseHandler(str){
                    if(str.error){
                        if(str.error == 'login_error'){
                            return 'Authentication Failed.'
                        }
                        else if(str.error == 'forbbiden'){
                            if (!auth.Authenticated()) {
                                return this.$router.push({name: 'page-not-authorized'})
                            }
                            return this.$router.push({name: 'dashboard'})
                        }
                        else if(str.error == 'Unauthorized'){
                            if (!auth.Authenticated()) {
                                return this.$router.push({name: 'page-not-authorized'})
                            }
                            localStorage.removeItem('user')
                            return this.$router.push({name: 'page-session-expired'})
                        }
                        else{
                            return this.$router.push({name: 'server-maintenance'})
                        }
                    }
                    else if(str.errors.username && str.errors.password){
                        return str.errors.username[0] + '</br>' + str.errors.password[0]
                    }
                    else if(str.errors.username){
                        return str.errors.username[0]
                    }
                    else if(str.errors.password){
                        return str.errors.password[0]
                    }else if(str.message == 'CSRF token mismatch.'){
                        location.reload()
                    }
                }
            }
        })
    }
}
export default myPlugins
