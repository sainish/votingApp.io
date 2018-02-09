
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .pointer {cursor: pointer;}

</style>
@extends('layouts.app')

@section('content')
<div id="app">
    <!--    <example-component>
        </example-component>-->

    <div class="container" >
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header"> 
                        <h1><i class="fa fa-thumbs-up"></i>
                            Food Voting</h1>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li v-for="(item, index) in items" class="list-group-item">
                                            <div class="radio pointer">
                                                <label>
                                                    <label class="btn btn-info active">
                                                        <input type="radio" name="voteOption" id="" autocomplete="off" :value="item['id']"
                                                               v-model="selectedFood">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </label>
                                                                            <!--<input type="radio" name="optionsRadios">--> 
                                                    &nbsp; &nbsp; &nbsp;
                                                    <img  :src="item['img_url']" width="50" height="50"/>
                                                    @{{item['name']}}

                                                </label>

                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <div class="row">

                                        <div class="col-sm-10">
                                            <div class="alert alert-info"  
                                                 v-bind:class="{ 'alert-success': isSuccess, 'alert-danger': hasError }">
                                                <span class="success">@{{error}}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary btn-md" v-on:click="addVote"  >
                                                Vote
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="panel-body">-->
                                <!--                                    <ul class="list-group">
                                                                        @foreach($data as $item)
                                                                        <li class="list-group-item">
                                                                            <div class="radio pointer">
                                                                                <label>
                                                                                    <label class="btn btn-info active">
                                                                                        <input type="radio" name="options" id="option2" autocomplete="off" chacked>
                                                                                        <span class="glyphicon glyphicon-ok"></span>
                                                                                    </label>
                                                                                                            <input type="radio" name="optionsRadios"> 
                                                                                    &nbsp; &nbsp; &nbsp;
                                                                                    <img src="{{$item['img_url']}}" width="50" height="50"/>
                                                                                    {{$item['name']}}
                                
                                                                                </label>
                                
                                                                                <div class="progress">
                                                                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>-->
                                <!--</div>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="piechart"></div>

            </div>
        </div>
            <!--<script src="https://unpkg.com/vue"></script>-->


    </div>
</div>

@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
<script>
//var example2 = new Vue({
//  el: '#example-2',
//  data: {
//    name: 'Vue.js'
//  },
//  // define methods under the `methods` object
//  methods: {
//    greet: function (event) {
//      // `this` inside methods points to the Vue instance
//      alert('Hello ' + this.name + '!')
//      // `event` is the native DOM event
//      if (event) {
//        alert(event.target.tagName)
//      }
//    }
//  }
//})

</script>
