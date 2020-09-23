<script>
  import { Pie } from 'vue-chartjs'

  export default {
    extends: Pie,
    data () {
      return {
        chartData: {
          labels: ["Italy", "India", "Japan", "USA",],
          datasets: [{
              borderWidth: 1,
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'            
              ],
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',                
              ],
              data: [1000,	500,	1500,	1000]
            }]
        },
        options: {
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    mounted () {
      this.renderChart(this.chartData, this.options)
    },
    created(){
      this.$http.post(`${this.url}/v1/pie`)
          .then(res => {
              // let data = decrypt(JSON.parse(res.data.message))
              this.chartData.labels.splice(0)
              this.chartData.datasets[0].borderColor.splice(0)
              this.chartData.datasets[0].backgroundColor.splice(0)
              this.chartData.datasets[0].data.splice(0)
              // Transfer New Data
              this.chartData.labels = res.data.labels

              let bg = []
              for(let x = 0; x < this.chartData.labels.length; x++){
                bg.push(this.random_bg_color())
              }
              this.chartData.datasets[0].borderColor = bg
              this.chartData.datasets[0].backgroundColor = bg
              this.chartData.datasets[0].data = res.data.data
              this.renderChart(this.chartData, this.options)
          })
          .catch(err => {
              console.log(err)
          });
    },
    methods: {
      random_bg_color() {
        var x = Math.floor(Math.random() * 256);
        var y = Math.floor(Math.random() * 256);
        var z = Math.floor(Math.random() * 256);
        var bgColor = "rgb(" + x + "," + y + "," + z + ")";
        return bgColor;
      } 
    }
  }
</script>