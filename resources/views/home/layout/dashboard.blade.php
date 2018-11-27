@extends('admin.layout.main_layout')
@section('user',Auth::user()->user_type)
@section('content')
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{URL::to('master/addorder')}}">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua" style="font-size: 30px;">ORDER</span>

                    <div class="info-box-content">
                        <h2 class="info-box-text" style="font-size: 33px;">ADD NEW </h2>
                    </div>

                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{URL::to('master/adddue')}}">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua" style="font-size: 30px;">DUE</span>

                    <div class="info-box-content">
                        <h2 class="info-box-text" style="font-size: 33px;">ADD NEW </h2>      
                    </div>

                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{URL::to('master/addcost')}}">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua" style="font-size: 30px;">COST</span>

                    <div class="info-box-content">
                        <h2 class="info-box-text" style="font-size: 33px;">ADD NEW </h2>                        
                    </div>

                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
    </div>
</section>
        
  @stop


