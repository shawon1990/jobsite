<?php use App\Http\Controllers\HomeController; ?>
<div class="col-md-3 col-md-offset-1">
    <div class="alert-box-info shadow">
        <!-- <h3>Get Best match jobs on your mail.No registration needed</h3> -->
        <a class="btn btn-info btn-alert" data-toggle="modal" data-target="#jobAlertModal" id="job-alert-btn" href="javascript:void(0)">Create Job Alert</a>
    </div>
    <div class="panel panel-info panel-cstm shadow">
        <div class="panel-heading">
            <h3 class="panel-title" title="recent job news in bangladesh">Recent Jobs</h3>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($recentJob as $k=>$v)
                    <a href="{{URL::to('jobDetails/'.HomeController::urlFixer($v->job_title).'/'.$v->id.'/'.$v->company_id)}}" class="list-group-item">{{substr($v->job_title,0,25)}}</a>
                @endforeach
            </ul>
            <hr class="hr-cstm">
            <a href="{{URL::to('findjobs')}}" class="a-more">More &nbsp;<i class="fa fa-angle-right"></i></a>
        </div>
    </div>
    <div class="panel panel-info panel-cstm shadow">
        <div class="panel-heading">
            <h1 class="panel-title" title="Advertisement">Advertisement</h1>
        </div>
        <div class="panel-body clearfix">
            <ul class="ad-list">
                <li>
                    <img src="{{URL::to('resources/assets/home/img/clients/kems.png')}}" class="img-responsive"  alt="KEMS GROUP"/>
                    <a href="http://www.kemsgroup.com/" title="KEMS GROUP" target="_blank">KEMS GROUP</a>
                </li>
                <li>
                    <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                    <a href="#">lynux Corp.</a>
                </li>
                <li>
                    <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                    <a href="#">lynux Corp.</a>
                </li>
                <li>
                    <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                    <a href="#">lynux Corp.</a>
                </li>
            </ul>
            <hr class="hr-cstm">
            <a href="#" class="a-more">More &nbsp;<i class="fa fa-angle-right"></i></a>
        </div>
    </div>

    <div class="advert-areas">
        <img src="{{asset('public/uploaded/advertisement/advertisement1.jpg')}}" alt="Bangladesh German technical institute" class="img-responsive" alt="image" />
        <img src="{{asset('public/uploaded/advertisement/advertisement2.png')}}" alt="Bangladesh korea technical center" class="img-responsive" alt="image" />
        <img src="{{asset('public/uploaded/advertisement/advertisement3.png')}}" alt="MAWTS" class="img-responsive" alt="image" />
        <img src="{{asset('public/uploaded/advertisement/advertisement4.png')}}" alt="UCEP" class="img-responsive" alt="image" />
    </div>


</div>
