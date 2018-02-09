
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var axios = require('axios');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue.js!',
        parentMessage: 'Parent',
        error: "Select food and click vote button to make difference.",
        items: [],
        selectedFood: false,
        isSuccess: false,
        hasError: false,
        googleChartData: [['Fruits', 'Users'],
           ]
    },
    mounted() {

        this.fetchFoodList();
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(this.drawChart);


    },

    methods: {
        drawChart: function (event) {
            var data = google.visualization.arrayToDataTable(
                    this.googleChartData
                    );
            // Optional; add a title and set the width and height of the chart
            var options = {'title': 'Students Voting', 'width': '100%', 'height': '100%'};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        },
        fetchFoodList: function (e) {
            const vm = this;
            axios.get(config.routes.getFoodList)
                    .then(function (response) {
                        vm.items = response.data;
                        var index;
                        for (index = 0; index < response.data.length; ++index) {
                            vm.googleChartData.push([response.data[index]['name'],response.data[index]['percent']]);
                        }
                        
                    })
                    .catch(function (error) {
                        // Wu oh! Something went wrong
                        console.log(error.message);
                    });
        },
        addVote: function (event) {
            const this_vm = this;
            this_vm.fetchFoodList()
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
            })
                    .catch(function (error) {
                        console.log(error);
                    });

        }
    }
});