@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenido</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <table class="table table-bordered" id="tblParks">
                                <thead>
                                    <tr>
                                        <th>Parqueaderos</th>
                                        <th>Total</th>
                                    <tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                        <div class="col-lg-4">
                            <table class="table table-bordered" id="tblStake">
                                <thead>
                                    <tr>
                                        <th>Clasificación</th>
                                        <th>Total</th>
                                    <tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                        <div class="col-lg-4">
                            <table class="table table-bordered" id="tblOrders">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Total</th>
                                    <tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Html::script('js/home.js')!!}

@endsection
