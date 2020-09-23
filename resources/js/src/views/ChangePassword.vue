<template>
    <v-container>
        <v-row>
            <v-col class="d-flex flex-row mb-6">
                <h2>Change Password</h2>
            </v-col>
            <v-breadcrumbs :items="bread_items">
                <template v-slot:divider>
                    <v-icon>mdi-chevron-right</v-icon>
                </template>
            </v-breadcrumbs>
        </v-row>
        <v-row>
          <v-col>
            <v-spacer></v-spacer>
            <v-card outlined  max-width="350px">
              <v-card-text>
                <v-form>
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
                    <v-text-field
                        ref="confirm_password"
                        v-model.trim="credentials.confirm_password"
                        :rules="[() => !!credentials.confirm_password || 'This field is required']"
                        :error-messages="errorMessages"
                        id="confirm_password"
                        label="Confirm Password"
                        name="confirm_password"
                        prepend-icon="mdi-lock"
                        type="confirm_password"
                        required
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn class="primary mb-3 mr-2" style="width:25%" outlined dark dense @click="changePass()">Update</v-btn>
            </v-card-actions>
          </v-card>
          </v-col>
        </v-row>

    </v-container>
    
</template>
<script>
export default {
    data() {
        return {
          errorMessages: '',
          credentials: {
            password: '',
            confirm_password: '',
          },
          bread_items: [
              {
                  text: 'Account Management',
                  disabled: false,
                  href: 'breadcrumbs_dashboard',
              },
              {
                  text: 'Change Password',
                  disabled: true,
                  href: 'breadcrumbs_dashboard',
              }
          ],
        }
    },
    methods: {
        changePass(){
            this.$http.post(`${this.url}/v1/change_password`, this.credentials)
            .then(res => {
                this.$toast.success(res.data.message);
                this.credentials.password = ''
                this.credentials.confirm_password = ''
            })
            .catch(err => {
                console.log(err)
                this.$toast.error(res.response.data.message);
            });
        },
    },
}
</script>
<style lang="scss">

</style>
