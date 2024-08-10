<template>
  <div>
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ dataset[5] + dataset[6] }}</h3>
            <p>Total Clients</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ dataset[5] }}</h3>
            <p>Clients Servis</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ formatTime(dataset[7]) }}</h3>
            <p>Temps Moyen d'Attente</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ dataset[6] }}</h3>
            <p>Clients Non Servis</p>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <div class="row">
      <div v-if="name === 'agencies'" class="col-md-6">
        <TopAgences :timeFilter="timeFilter"></TopAgences>
      </div>
      <div v-if="name !== 'service'" class="col-md-6">
        <TopServices :timeFilter="timeFilter" :name="name" :name_id="name_id"></TopServices>
      </div>
    </div>

    <div style="display: flex;">
      <div class="card card-primary card-outline" style="width: 600px;" :style="!ShowList1 ? {height: '50px'} : { height: '350px' }">
        <div class="card-header">
          <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Total des Clients au Fil du Temps
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList(1)">
              <i :class="ShowList1 ? 'fas fa-minus' : 'fas fa-plus'"></i>
            </button>
          </div>
        </div>
        <div class="card-body" v-if="ShowList1">
          <div id="line-chart" style="height: 300px; padding: 0px; position: relative;">
            <canvas id="myChart" style="width: 100%; max-width: 500px;"></canvas>
          </div>
        </div>
      </div>
      <div class="card card-primary card-outline" style="width: 600px; margin-left: 20px;" :style="!ShowList2 ? {height: '50px'} : { height: '350px' }">
        <div class="card-header">
          <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Clients Servis vs. Clients Non Servis
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList(2)">
          <i :class="ShowList2 ? 'fas fa-minus' : 'fas fa-plus'"></i>
        </button>
            
          </div>
        </div>
        <div class="card-body" v-if="ShowList2">
          <div id="line-chart" style="height: 300px; padding: 0px; position: relative;">
            <canvas id="myChart2" style="width: 100%; max-width: 500px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div style="display: flex;">
      <div class="card card-primary card-outline" style="width: 600px;" :style="!ShowList3 ? {height: '50px'} : { height: '350px' }">
        <div class="card-header">
          <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Temps Moyen d'Attente
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList(3)">
          <i :class="ShowList3 ? 'fas fa-minus' : 'fas fa-plus'"></i>
        </button>
           
          </div>
        </div>
        <div class="card-body" v-if="ShowList3">
          <div id="line-chart" style="height: 300px; padding: 0px; position: relative;">
            <canvas id="myChart3" style="width: 100%; max-width: 500px;"></canvas>
          </div>
        </div>
      </div>
      <div class="card card-primary card-outline" style="width: 600px; margin-left: 20px;" :style="!ShowList4 ? {height: '50px'} : { height: '350px' }">
        <div class="card-header">
          <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Taux de Service Client          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" @click="toggleShowList(4)">
          <i :class="ShowList4 ? 'fas fa-minus' : 'fas fa-plus'"></i>
        </button>
           
          </div>
        </div>
        <div class="card-body" v-if="ShowList4">
          <div id="line-chart" style="height: 300px; padding: 0px; position: relative;">
            <canvas id="myChart4" style="width: 100%; max-width: 500px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from 'axios';
import TopAgences from './TopAgences.vue';
import TopServices from './TopServices.vue';

export default {
  name: 'LineChartStat',
  data() {
    return {
      ShowList1:true,
      ShowList2:true,
      ShowList3:true,
      ShowList4:true,
      dataset: [0, 0, 0, 0, 0, 0, 0, 0],
      myChart: null,
      myChart2: null,
      myChart3: null,
      myChart4: null,
      updateInterval: null
    };
  },
  components: { TopAgences, TopServices },
  props: {
    name: String,
    name_id: [Number, String],
    timeFilter: Number,
  },
  computed: {
    combinedParams() {
      // Combine all parameters that affect fetching data
      return `${this.name}-${this.name_id}-${this.timeFilter}`;
    }
  },

  methods: {
    toggleShowList(n) {
      if(n==1){this.ShowList1 = !this.ShowList1;}
      else if(n==2){this.ShowList2 = !this.ShowList2;}
      else if(n==3){this.ShowList3 = !this.ShowList3;}
      else  this.ShowList4 = !this.ShowList4;
    },
    async getStatistiques() {
  try {
    let response;
    if (this.name === "service") {
      response = await axios.get(`/service/${parseInt(this.name_id)}/LineChartStat/${this.timeFilter}`);
      console.log("service data = ",response.data);
    } else if (this.name === "agencies") {
      response = await axios.get(`/LineChartStatAgences/${this.timeFilter}`);
      console.log("agencies data = ",response.data);
    } else {
      response = await axios.get(`/agence/${parseInt(this.name_id)}/LineChartStat/${this.timeFilter}`);
      console.log("agence data = ",response.data);
    }
    this.dataset = response.data;
    
    // Ensure canvas elements are ready before drawing charts
    this.$nextTick(() => {

      if(this.dataset) this.drawChart();
    });
  } catch (error) {
    console.error('Error fetching statistics:', error);
  }
},
drawChart() {
  // Destroy any existing chart instances
  if (this.myChart) this.myChart.destroy();
  if (this.myChart2) this.myChart2.destroy();
  if (this.myChart3) this.myChart3.destroy();
  if (this.myChart4) this.myChart4.destroy();

  // Ensure dataset structure is correct before creating charts
  if (!Array.isArray(this.dataset[2]) || !Array.isArray(this.dataset[0]) || !Array.isArray(this.dataset[1]) || !Array.isArray(this.dataset[3])) {
    console.error("Dataset structure is incorrect", this.dataset);
    return;
  }

  const xValues = this.generateXValues();

  try {
    const ctx1 = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');
    const ctx3 = document.getElementById('myChart3');
    const ctx4 = document.getElementById('myChart4');

    this.myChart = new Chart(ctx1, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          data: this.dataset[2],
          borderColor: "blue",
          fill: false,
          label: 'Total Clients',
        }]
      },
      options: this.getChartOptions('Total Clients')
    });

    this.myChart2 = new Chart(ctx2, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          data: this.dataset[0],
          borderColor: "green",
          fill: false,
          label: 'Clients Servis',
        }, {
          data: this.dataset[1],
          borderColor: "red",
          fill: false,
          label: 'Clients Non Servis',
        }]
      },
      options: this.getChartOptions('Clients Servis et Non Servis')
    });

    this.myChart3 = new Chart(ctx3, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          data: this.dataset[3],
          borderColor: "orange",
          fill: false,
          label: "Temps Moyen d'attente",
        }]
      },
      options: this.getChartOptions("Temps Moyen d'attente en h")
    });

    this.myChart4 = new Chart(ctx4, {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          data: this.dataset[4],
          borderColor: "green",
          fill: false,
          label: 'Taux de clients servis',
        }]
      },
      options: this.getChartOptions('Taux de clients servis en %')
    });
  } catch (error) {
    console.error("Error while drawing charts:", error);
  }
},


    generateXValues() {
      let xValues = [];
      const today = new Date();
      if (this.timeFilter === 1) {
        xValues = Array.from({ length: 12 }, (_, i) => `${i + 8}:00`);
      } else if (this.timeFilter === 365) {
        for (let i = 0; i < 12; i++) {
          const date = new Date(today.getFullYear(), today.getMonth() - i, 1);
          xValues.unshift(date.toLocaleString('en-GB', { month: 'short', year: 'numeric' }));
        }
      } else if (this.timeFilter === 30 || this.timeFilter === 7) {
        for (let i = this.timeFilter - 1; i >= 0; i--) {
          const date = new Date(today);
          date.setDate(today.getDate() - i);
          xValues.push(date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' }));
        }
      }
      return xValues;
    },
    getChartOptions(yAxisLabel) {
      return {
        scales: {
          x: {
            grid: { display: false },
            ticks: { display: true },
            title: { display: true, text: this.getXAxisTitle() }
          },
          y: {
            title: { display: true, text: yAxisLabel }
          }
        },
        plugins: { legend: { display: true } }
      };
    },
    getXAxisTitle() {
  if (this.timeFilter === 1) return 'Heures';
  if (this.timeFilter === 365) return 'Les 12 derniers mois';
  if (this.timeFilter === 30) return 'Les 30 derniers jours';
  if (this.timeFilter === 7) return 'Les 7 derniers jours';
  return '';
},

    formatTime(heure) {
      const heures = parseInt(heure);
      const remainingMinutes = (heure - heures) * 60;
      return `${heures}h ${parseInt(remainingMinutes)}m`;
    }
  },
  mounted() {
    this.getStatistiques();
    this.updateInterval = setInterval(this.getStatistiques,20000);
  },
  beforeDestroy() {
    clearInterval(this.updateInterval);
  },
  watch: {
    combinedParams: 'getStatistiques',
  },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
