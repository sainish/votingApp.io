@extends('layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    [v-cloak] {
        display: none;
    }
</style>

@section('content')
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"> 
                        <h1>
                            <i class="fa fa-thumbs-up"></i>
                            Food Voting
                        </h1>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div v-if="loading">
                                    <h3 align="center"><i class="fa fa-spinner fa-spin" style="font-size:40px"></i></h3>
                                </div>
                                <div class="panel-body" v-cloak>
                                    <h4 align="center">Total Vote Given: @{{totalVoteGivenAll}}</h4>
                                    <ul class="list-group">
                                        <li v-for="(item, index) in items" class="list-group-item">
                                            <div class="radio pointer">
                                                <label>
                                                    <label class="btn btn-info active">
                                                        <input type="radio" name="voteOption"
                                                               autocomplete="off" 
                                                               :value="item['id']"
                                                               v-model="selectedFood">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </label>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <img  :src="item['img_url']" width="50" height="50"/>
                                                    @{{item['name']}}
                                                </label>

                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" 
                                                         v-bind:style="{width: item['percent']+'%'}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        @{{item['totalVoteGiven']}} / @{{totalVoteGivenAll}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-10"  v-cloak>
                                            <div class="alert alert-info"  
                                                 v-bind:class="{ 'alert-success': isSuccess, 'alert-danger': hasError }">
                                                <span class="success">@{{error}}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary btn-md"
                                                    v-on:click="addVote"  >
                                                Vote
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="piechart"></div>
            </div>
        </div>
    </div>
@endsection
