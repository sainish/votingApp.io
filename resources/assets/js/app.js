require('./bootstrap');
var axios = require('axios');

window.Vue = require('vue');

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Student!',
        error: "Select food and click vote button to make difference.",
        items: [],
        selectedFood: false,
        isSuccess: false,
        hasError: false,
        googleChartData: [['Fruits', 'Users'],
        ],
        chart:'',
        googleChartOptions:'',
        data:''
    },
    mounted() {
        
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(this.drawChart);
        this.fetchFoodList();
        
    },
    

    methods: {
        drawChart: function (event) {
            this.data = google.visualization.arrayToDataTable(
                    this.googleChartData
                    );
            // Optional; add a title and set the width and height of the chart
            this.googleChartOptions = {'title': 'Students Voting', 'width': '100%', 'height': '100%'};
            this.chart = new google.visualization.PieChart(document.getElementById('piechart'));
            this.chart.draw(this.data, this.googleChartOptions);
            
        },
        fetchFoodList: function (event) {
            const vm = this;
            axios.get(config.routes.getFoodList)
                    .then(function (response) {
                        vm.items = response.data;
                        var index;
                        console.log(response.data)
                        console.log(response.data.length)
                        vm.googleChartData = [['Fruits', 'Users']];
                        for (index = 0; index < response.data.length; ++index) {
                            vm.googleChartData.push([response.data[index]['name'], response.data[index]['percent']]);
                        }
                        vm.drawChart();
                    })
                    .catch(function (error) {
                        // Wu oh! Something went wrong
                        console.log(error.message);
                    });
        },
        addVote: function (event) {
            const this_vm = this;
            
            if (this_vm.selectedFood === false) {
                this_vm.isSuccess = false;
                this_vm.hasError = true;
                this_vm.error = "Please select any one option.";
                return;
            }
            axios.post(config.routes.giveVote, {
                selectedFood: this_vm.selectedFood,
            }).then(function (response) {
                if (response.data.status == "created") {
                    this_vm.isSuccess = true;
                    this_vm.hasError = false;
                    this_vm.error = "yey! Your voice has been raised successfully :)";
                } else {
                    this_vm.hasError = true;
                    this_vm.isSuccess = false;
                    this_vm.error = "You already voted for " + response.data[0].name + ".";
                }
                this_vm.fetchFoodList();
            })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
});