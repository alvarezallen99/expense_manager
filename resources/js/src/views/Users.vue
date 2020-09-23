<template>
    <v-container>
        <v-row>
            <v-col class="d-flex flex-row mb-6">
                <h2>Users</h2>
            </v-col>
            <v-breadcrumbs :items="bread_items">
                <template v-slot:divider>
                    <v-icon>mdi-chevron-right</v-icon>
                </template>
            </v-breadcrumbs>
        </v-row>
        <v-card outlined>
            <v-simple-table class="mr-5 ml-5 mt-5" id="mytable" fixed-header dense stripe height="250px">
                <template v-slot:default>
                <thead >
                    <tr>
                        <th id="left-header" class="text-left">Name</th>
                        <th id="middle-header" class="text-left">Email Address</th>
                        <th id="middle-header" class="text-left">Role</th>
                        <th id="right-header" class="text-left">Created at</th>
                    </tr>
                </thead>
                <tbody >
                    <tr :key="indextr" v-for="(tr, indextr) in tbldata" @click="showUpdateDialog(tbldata[indextr].id)">
                    <td style="border-right: 2px solid black" >{{ tbldata[indextr].name }}</td>
                    <td style="border-right: 2px solid black" >{{ tbldata[indextr].email }}</td>
                    <td style="border-right: 2px solid black" >{{ tbldata[indextr].role_name }}</td>
                    <td>{{ tbldata[indextr].created_at }}</td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn class="primary mr-3" outlined small dark @click="showAddRoleForm()">Add User</v-btn>
            </v-card-actions>
        </v-card>

        <v-row justify="center">

            <v-dialog v-model.trim="addDialog" persistent max-width="350px" dense>
                <v-card >
                    <v-card-title>Add User</v-card-title>
                    <v-divider></v-divider><br>
                    <v-form ref="form" :lazy-validation="true">
                        <v-card-text class="mt-n5">
                            <v-text-field
                                ref="name"
                                v-model.trim="addForm.name"
                                :rules="[() => !!addForm.name || 'This field is required']"
                                :error-messages="errorMessages"
                                label="Name"
                                placeholder="Name"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-n5 mb-n10">
                            <v-text-field
                                ref="email"
                                v-model.trim="addForm.email"
                                :rules="[() => !!addForm.email || 'This field is required']"
                                :error-messages="errorMessages"
                                label="Email Address"
                                type="email"
                                placeholder="Email Address"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-2 mb-n10">
                            <v-text-field
                                ref="password"
                                v-model.trim="addForm.password"
                                :rules="[() => !!addForm.password || 'This field is required']"
                                :error-messages="errorMessages"
                                label="Password"
                                placeholder="Password"
                                type="password"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-5 mb-n10">
                            <v-select
                                ref="role_name"
                                v-model.trim="addForm.role_name"
                                :rules="[() => !!addForm.role_name || 'Role is required']"
                                :error-messages="errorMessages"
                                :items="dropdown_roles"
                                label="Role"
                                required
                                dense
                            ></v-select>
                        </v-card-text>
                    </v-form>
                    <v-divider class="mt-12"></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="warning" @click="cancelUserForm()" small dark width="75px" outlined>CANCEL</v-btn>
                        <v-btn color="primary" @click="addUser()" small dark width="75px">SAVE</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog v-model.trim="updateDialog" persistent max-width="350px" dense>
                <v-card >
                    <v-card-title>Update User</v-card-title>
                    <v-divider></v-divider><br>
                    <v-form ref="form" :lazy-validation="true">
                        <v-card-text class="mt-n5">
                            <v-text-field
                                ref="name"
                                v-model.trim="updateForm.name"
                                :rules="[() => !!updateForm.name || 'This field is required']"
                                :error-messages="errorMessages"
                                label="Name"
                                placeholder="Name"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-n5 mb-n10">
                            <v-text-field
                                ref="email"
                                v-model.trim="updateForm.email"
                                :rules="[() => !!updateForm.email || 'This field is required']"
                                :error-messages="errorMessages"
                                label="Email Address"
                                type="email"
                                placeholder="Email Address"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-2 mb-n10">
                            <v-text-field
                                ref="password"
                                v-model.trim="updateForm.password"
                                :rules="[() => !!updateForm.password || 'This field is required']"
                                :error-messages="errorMessages"
                                label="New Password"
                                placeholder="New Password"
                                type="password"
                                required
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-5 mb-n10">
                            <v-select
                                ref="role_name"
                                v-model.trim="updateForm.role_name"
                                :rules="[() => !!updateForm.role_name || 'Role is required']"
                                :error-messages="errorMessages"
                                :items="dropdown_roles"
                                label="Role"
                                required
                                dense
                            ></v-select>
                        </v-card-text>
                    </v-form>
                    <v-divider class="mt-12"></v-divider>
                    <v-card-actions>
                        <v-btn color="error" @click="deleteDialog = true" small width="75px">DELETE</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="warning" @click="cancelUserForm()" small dark width="75px" outlined>CANCEL</v-btn>
                        <v-btn color="primary" @click="updateUser()" small dark width="75px">UPDATE</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog v-model="deleteDialog" persistent max-width="290">
                <v-card>
                    <v-card-title class="headline">Delete?</v-card-title>
                        <v-card-text>Are you sure you want to delete this user?</v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn color="warning darken-1" text @click="deleteDialog = false">Cancel</v-btn>
                        <v-btn color="error darken-1" text @click="deleteUser()">Confirm</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

    </v-container>
</template>
<script>
export default {
    data() {
        return {
            addDialog: false,
            updateDialog: false,
            deleteDialog: false,
            errorMessages: '',
            dropdown_roles: [],
            tbldata: [],
            addForm: {
                name: '',
                email: '',
                password: '',
                role_name: ''
            },
            updateForm: {
                id: '',
                name: '',
                email: '',
                password: '',
                role_name: ''
            },
            bread_items: [
                {
                    text: 'User Management',
                    disabled: false,
                    href: 'breadcrumbs_dashboard',
                },
                {
                    text: 'Users',
                    disabled: true,
                    href: 'breadcrumbs_link_1',
                }
            ],
        }
    },
    created() {
        this.getData()
    },
    methods: {
        getData(){
            this.$http.post(`${this.url}/v1/users`)
            .then(res => {
                let data = res.data.message
                this.tbldata.splice(0)
                for(let x = 0; x < data.length; x++){
                    this.tbldata.push(data[x])
                }
                this.dropdown_roles.splice(0)
                this.dropdown_roles = res.data.roles
            })
            .catch(err => {
                console.log(err)
            });
        },
        deleteUser(){
            this.$http.post(`${this.url}/v1/delete_user`, this.updateForm)
            .then(res => {
                let data = res.data.message
                for (let x = 0; x < this.tbldata.length; x++){
                    if(this.tbldata[x].id == this.updateForm.id){
                        this.tbldata.splice(x, 1)
                    }
                }
                this.deleteDialog = false
                this.updateDialog = false
                this.$toast.success(res.data.message);
            })
            .catch(err => {
                if(err.response.data.message != undefined){
                    this.$toast.warning(err.response.data.message);
                    return;
                }
                this.$toast.error('Operation Failed!', String(err.response.status));
                console.clear()
            });
        },
        showAddRoleForm(){
            this.addDialog = true
            this.resetForms()
            if(this.$refs.form != undefined)
            this.$refs.form.resetValidation()
        },
        addUser(){
            this.$http.post(`${this.url}/v1/add_user`, this.addForm)
            .then(res => {
                let data = res.data.message
                this.tbldata.push(data[0])
                this.addDialog = false
                this.$toast.success('Successfully Added User!') 
            })
            .catch(err => {
                if(err.response.data.message != undefined){
                    this.$toast.warning(err.response.data.message);
                    return;
                }
                this.$toast.error('Operation Failed!', String(err.response.status));
                console.clear()
            });
        },
        showUpdateDialog(id){
            this.resetForms()
            for (let x = 0; x < this.tbldata.length; x++){
                if(this.tbldata[x].id == id){
                    this.updateForm.id = this.tbldata[x].id
                    this.updateForm.name = this.tbldata[x].name
                    this.updateForm.email = this.tbldata[x].email
                    this.updateForm.role_name = this.tbldata[x].role_name
                }
            }
            this.updateDialog = true
            if(this.$refs.updateform != undefined)
            this.$refs.updateform.resetValidation()
        },
        updateUser(){
            this.$http.post(`${this.url}/v1/update_user`, this.updateForm)
            .then(res => {
                let data = res.data.message
                for(let x = 0; x < this.tbldata.length; x++){
                    if(this.tbldata[x].id == data[0].id){
                        this.tbldata[x].name = data[0].name
                        this.tbldata[x].email = data[0].email
                        this.tbldata[x].role = data[0].role
                        this.tbldata[x].role_name = data[0].role_name
                        this.tbldata[x].created_at = data[0].created_at
                    }
                }
                this.updateDialog = false
                this.$toast.success('Successfully Updated User!') 
            })
            .catch(err => {
                if(err.response.data.message != undefined){
                    this.$toast.warning(err.response.data.message);
                    return;
                }
                this.$toast.error('Operation Failed!', String(err.response.status));
                console.clear()
            });
        },
        cancelUserForm(){
            this.addDialog = false
            this.updateDialog = false
        },
        resetForms(){
            this.addForm.name = ''
            this.addForm.email = ''
            this.addForm.password = ''
            this.addForm.role_name = ''
            this.updateForm.id = ''
            this.updateForm.name = ''
            this.updateForm.email = ''
            this.updateForm.password = ''
            this.updateForm.role_name = ''
        }
    }
}
</script>
<style scoped>

tbody tr:nth-of-type(even) {
    background-color: rgba(236, 237, 237);
}

tbody tr:nth-of-type(odd) {
    background-color: rgb(250 ,250, 250);
}

.table >>> .table tfoot tr {
    border-bottom: solid 1px black;
}

#left-header, #right-header, #middle-header{
    background-color: #b0bec5;
}

#left-header{
    border-right: 2px solid black;
}

#middle-header {
    border-right: 2px solid black;
}

#mytable {
    border: 2px solid black;
}

</style>
