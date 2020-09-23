<template>
    <v-container>
        <v-row>
            <v-col class="d-flex flex-row mb-6">
                <h2>Dashboard</h2>
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
            <v-card outlined height="300px">
              <v-simple-table class="mr-5 ml-5 mt-5" id="mytable" fixed-header dense stripe height="250px">
                  <template v-slot:default>
                  <thead >
                      <tr>
                          <th class="text-left">Expense Categories</th>
                          <th class="text-left">Total</th>
                      </tr>
                  </thead>
                  <tbody >
                      <tr :key="indextr" v-for="(tr, indextr) in tbldata">
                      <td>{{ tbldata[indextr].category_name }}</td>
                      <td>${{ tbldata[indextr].total_amount }}</td>
                      </tr>
                  </tbody>
                  </template>
              </v-simple-table>
          </v-card>
          </v-col>
          <v-col>
            <pie-chart></pie-chart>
          </v-col>
        </v-row>

    </v-container>
    
</template>
<script>
import PieChart from '../../components/PieChart'
export default {
    data() {
        return {
          tbldata: [],
          bread_items: [
              {
                  text: 'DashBoard',
                  disabled: true,
                  href: 'breadcrumbs_dashboard',
              }
          ],
        }
    },
    created() {
        this.getData()
    },
    methods: {
        getData(){
            this.$http.post(`${this.url}/v1/dashboard`)
            .then(res => {
                let data = res.data.message
                this.tbldata.splice(0)
                for(let x = 0; x < data.length; x++){
                    this.tbldata.push(data[x])
                }
            })
            .catch(err => {
                console.log(err)
            });
        },
    },
    components: {
      PieChart
    },
}
</script>
<style lang="scss">

</style>
