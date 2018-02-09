
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
        selectedFood: [],
        isSuccess: false,
        hasError: false,
        googleChartData: [['Task', 'Hours per Day'],
            ['Work', 8],
            ['Eat', 2],
            ['TV', 4],
            ['Gym', 2],
            ['Sleep', 8]]
    },
    mounted() {
        const vm = this;

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(vm.drawChart);

        axios.get(config.routes.getFoodList)
                .then(function (response) {
                    vm.items = response.data;
                    console.log(vm.items);
                })
                .catch(function (error) {
                    // Wu oh! Something went wrong
                    console.log(error.message);
                });
    },

    methods: {
        drawChart: function (event) {
            var data = google.visualization.arrayToDataTable(
                    this.googleChartData
                    );
            // Optional; add a title and set the width and height of the chart
            var options = {'title': 'My Average Day', 'width': '100%', 'height': '100%'};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        },
        addVote: function (event) {
            // `this` inside methods points to the Vue instance
            // `event` is the native DOM event
            const this_vm = this;
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
                    this_vm.error = "I know " + response.data[0].name + " is awesome. But you can vote only once :)";
                }
                console.log(response);
            })
                    .catch(function (error) {
                        console.log(error);
                    });

        }
    }
});



// Draw the chart and set the chart values
function drawChart() {



}