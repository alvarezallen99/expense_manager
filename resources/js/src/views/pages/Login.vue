<template>
    <div id="app">
        <v-app id="inspire">
            <v-main>
            <v-container
                fluid
                fill-height
            >
                <v-layout
                align-center
                justify-center
                >
                <v-flex
                    xs12
                    sm8
                    md4
                >
                    <v-card class="elevation-12">
                    <v-toolbar
                        color="primary"
                        dark
                        flat
                        dense
                    >
                        <v-toolbar-title>Expense Manager Login</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <v-form>
                        <v-text-field
                            ref="email"
                            v-model.trim="credentials.email"
                            :rules="[() => !!credentials.email || 'This field is required']"
                            :error-messages="errorMessages"
                            label="Email"
                            name="email"
                            prepend-icon="mdi-email"
                            type="email"
                            required
                        ></v-text-field>

                        <v-text-field
                            ref="password"
                            v-model.trim="credentials.password"
                            :rules="[() => !!credentials.password || 'This field is required']"
                            :error-messages="errorMessages"
                            id="password"
                            label="Password"
                            name="password"
                            prepend-icon="mdi-lock"
                            type="password"
                            required
                        ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn class="primary mb-3 mr-2" style="width:25%" outlined dark dense @click="login()">Login</v-btn>
                    </v-card-actions>
                    </v-card>
                </v-flex>
                </v-layout>
            </v-container>
            </v-main>
        </v-app>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isLoading: false,
            errorMessages: '',
            credentials:{
                password: null,
                username: null
            }
        }
    },
    created(){
        
    },
    methods: {
        login(){
            this.$http.post(`${this.url}/v1/auth/login_check`, this.credentials)
            .then(res => {
                this.$toast.success('Login Successfull');
                this.setToken(res.headers.authorization)
                localStorage.setItem('user', res.data.UserData)
                this.$router.push({ path: '/'}).catch(()=>{});
            })
            .catch(err => {
                console.log(err)
                this.$toast.error('Login Failed');
            });
        }
    }
}
</script>
<style>
.v-btn, .v-card {
      border-radius: 4px;
}
.v-card__title {
      text-transform: uppercase;
}
</style>
