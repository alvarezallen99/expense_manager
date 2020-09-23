<template>
    <v-container>
        <v-row>
            <v-col class="d-flex flex-row mb-6">
                <h2>Expenses</h2>
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
                        <th id="left-header" class="text-left">Expense Category</th>
                        <th id="middle-header" class="text-left">Amount</th>
                        <th id="middle-header" class="text-left">Entry Date</th>
                        <th id="right-header" class="text-left">Created at</th>
                    </tr>
                </thead>
                <tbody >
                    <tr :key="indextr" v-for="(tr, indextr) in tbldata" @click="showUpdateDialog(tbldata[indextr].id)">
                    <td style="border-right: 2px solid black" >{{ tbldata[indextr].category_name }}</td>
                    <td style="border-right: 2px solid black" >${{ tbldata[indextr].amount }}</td>
                    <td style="border-right: 2px solid black" >{{ tbldata[indextr].entry_date }}</td>
                    <td>{{ tbldata[indextr].created_at }}</td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn class="primary mr-3" outlined small dark @click="showaddCategoryForm()">Add Expenses</v-btn>
            </v-card-actions>
        </v-card>

        <v-row justify="center">

            <v-dialog v-model.trim="addDialog" persistent max-width="600px" dense>
                <v-card >
                    <v-card-title>Add Expense</v-card-title>
                    <v-divider></v-divider><br>
                    <v-form ref="form" :lazy-validation="true">
                        <v-card-text class="mt-n5">
                            <v-select
                                ref="category_name"
                                v-model.trim="addForm.category_name"
                                :rules="[() => !!addForm.category_name || 'Expense Category is required']"
                                :error-messages="errorMessages"
                                :items="dropdown_categories"
                                label="Expense Category"
                                prepend-icon="mdi-format-list-bulleted-type"
                                required
                                dense
                            ></v-select>
                        </v-card-text>
                        <v-card-text class="mt-n5 mb-n10">
                            <v-text-field
                                ref="amount"
                                v-model.trim="addForm.amount"
                                :rules="[() => !!addForm.amount || 'This field is required']"
                                :error-messages="errorMessages"
                                prepend-icon="mdi-account-cash"
                                label="Amount"
                                placeholder="Amount"
                                required
                                @keypress="onlyNumber"
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-2 mb-n10">
                            <v-menu
                                v-model="menu2"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            ><template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    ref="entry_date"
                                    v-model="addForm.entry_date"
                                    :rules="[() => !!addForm.entry_date || 'This field is required']"
                                    :error-messages="errorMessages"
                                    label="Entry Date"
                                    hint="MM/DD/YYYY format"
                                    persistent-hint
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    required
                                ></v-text-field></template>
                                <v-date-picker v-model="addForm.entry_date" no-title @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-card-text>
                    </v-form>
                    <v-divider class="mt-12"></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="warning" @click="cancelRoleForm()" small dark width="75px" outlined>CANCEL</v-btn>
                        <v-btn color="primary" @click="addExpense()" small dark width="75px">SAVE</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog v-model.trim="updateDialog" persistent max-width="600px" dense>
                <v-card >
                    <v-card-title>Update Expense</v-card-title>
                    <v-divider></v-divider><br>
                    <v-form ref="updateform" :lazy-validation="true">
                        <v-card-text class="mt-n5">
                            <v-select
                                ref="category_name"
                                v-model.trim="updateForm.category_name"
                                :rules="[() => !!updateForm.category_name || 'Expense Category is required']"
                                :error-messages="errorMessages"
                                :items="dropdown_categories"
                                label="Expense Category"
                                prepend-icon="mdi-format-list-bulleted-type"
                                required
                                dense
                            ></v-select>
                        </v-card-text>
                        <v-card-text class="mt-n5 mb-n10">
                            <v-text-field
                                ref="amount"
                                v-model.trim="updateForm.amount"
                                :rules="[() => !!updateForm.amount || 'This field is required']"
                                :error-messages="errorMessages"
                                prepend-icon="mdi-account-cash"
                                label="Amount"
                                placeholder="Amount"
                                required
                                @keypress="onlyNumber"
                            ></v-text-field>
                        </v-card-text>
                        <v-card-text class="mt-2 mb-n10">
                            <v-menu
                                v-model="menu2"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            ><template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    ref="entry_date"
                                    v-model="updateForm.entry_date"
                                    :rules="[() => !!updateForm.entry_date || 'This field is required']"
                                    :error-messages="errorMessages"
                                    label="Entry Date"
                                    hint="MM/DD/YYYY format"
                                    persistent-hint
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    required
                                ></v-text-field></template>
                                <v-date-picker v-model="updateForm.entry_date" no-title @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-card-text>
                    </v-form>
                    <v-divider class="mt-12"></v-divider>
                    <v-card-actions>
                        <v-btn color="error" @click="deleteDialog = true" small width="75px">DELETE</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="warning" @click="cancelRoleForm()" small dark width="75px" outlined>CANCEL</v-btn>
                        <v-btn color="primary" @click="updateExpense()" small dark width="75px">UPDATE</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog v-model="deleteDialog" persistent max-width="290">
                <v-card>
                    <v-card-title class="headline">Delete?</v-card-title>
                        <v-card-text>Are you sure you want to delete this expense?</v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn color="warning darken-1" text @click="deleteDialog = false">Cancel</v-btn>
                        <v-btn color="error darken-1" text @click="deleteCategory()">Confirm</v-btn>
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
            date: new Date().toISOString().substr(0, 10),
            menu2: false,
            dropdown_categories: [],
            tbldata: [],
            addForm: {
                category_name: '',
                amount: '',
                entry_date: '',
            },
            updateForm: {
                id: '',
                category_name: '',
                amount: '',
                entry_date: '',
            },
            bread_items: [
                {
                    text: 'User Management',
                    disabled: false,
                    href: 'breadcrumbs_dashboard',
                },
                {
                    text: 'Expenses',
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
            this.$http.post(`${this.url}/v1/expenses`)
            .then(res => {
                let data = res.data.message
                this.tbldata.splice(0)
                for(let x = 0; x < data.length; x++){
                    this.tbldata.push(data[x])
                }
                this.dropdown_categories.splice(0)
                this.dropdown_categories = res.data.categories
            })
            .catch(err => {
                console.log(err)
            });
        },
        deleteCategory(){
            this.$http.post(`${this.url}/v1/delete_expenses`, this.updateForm)
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
        showaddCategoryForm(){
            this.addDialog = true
            this.resetForms()
            if(this.$refs.form != undefined)
            this.$refs.form.resetValidation()
        },
        addExpense(){
            this.$http.post(`${this.url}/v1/add_expenses`, this.addForm)
            .then(res => {
                let data = res.data.message
                this.tbldata.push(data[0])
                this.addDialog = false
                this.$toast.success('Successfully Added Expenses!') 
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
                    this.updateForm.id = id
                    this.updateForm.category_name = this.tbldata[x].category_name
                    this.updateForm.amount = this.tbldata[x].amount
                    this.updateForm.entry_date = this.tbldata[x].entry_date
                }
            }
            this.updateDialog = true
            if(this.$refs.updateform != undefined)
            this.$refs.updateform.resetValidation()
        },
        updateExpense(){
            this.$http.post(`${this.url}/v1/update_expenses`, this.updateForm)
            .then(res => {
                let data = res.data.message
                for(let x = 0; x < this.tbldata.length; x++){
                    if(this.tbldata[x].id == data[0].id){
                        this.tbldata[x].category_name = data[0].category_name
                        this.tbldata[x].amount = data[0].amount
                        this.updateForm.entry_date = data[0].entry_date
                        this.tbldata[x].created_at = data[0].created_at
                    }
                }
                this.updateDialog = false
                this.$toast.success('Successfully Updated Expenses!') 
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
        cancelRoleForm(){
            this.addDialog = false
            this.updateDialog = false
        },
        resetForms(){
            this.addForm.category_name = ''
            this.addForm.amount = ''
            this.addForm.entry_date = ''
            this.updateForm.id = ''
            this.updateForm.category_name = ''
            this.updateForm.amount = ''
            this.updateForm.entry_date = ''
        },
        onlyNumber($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
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
