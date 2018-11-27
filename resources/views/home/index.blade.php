<?php use App\Http\Controllers\HomeController; ?>
<html>
@include('home.layout.header')


<body class="page-index has-hero">
@if(session()->has('msg'))
    <div class="alert alert-success homepage-success-msg">
        {{ session()->get('msg') }}
    </div>
@endif
<!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
<div id="background-wrapper" class="buildings" style="background-position: -171px 118px;background-size: cover;background-attachment: fixed;">

    @include('home.layout.top_header')
    @include('home.layout.slider')
</div>
<!-- ======== @Region: #content ======== -->
<div id="content">
    <div class="container jobs-container">
        <div class="row clearfix">
            <div class="col-md-9">
                <div class="choose-category shadow">
                    <select class="form-control search-with-job-category-type" id="home_job_type">
                        <option value="0">Choose Job Type</option>
                        @foreach($jobType as $k=>$v)
                        <option value="{{$v->id}}" title="full time jobs, part time jobs,part time jobs near me,full time jobs near me,part time,full time jobs hiring,	online part time jobs,">
                           {{$v->job_type_name}}
                        </option>
                        @endforeach

                    </select>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                        <ul class="nav nav-pills nav-justified cstm-nav-category" id="home-job-tab-division">
                            <li class="active" data-name="all" onclick="searchWithJobCategoryTypeWithTimeout()"><a href="#tab-all" data-toggle="tab" title="todays all job, today all job vacancy, need a job today,new jobs today">All Jobs</a></li>
                            <li data-name="today" onclick="searchWithJobCategoryTypeWithTimeout()"><a href="#tab-today" data-toggle="tab" title="todays job, today job vacancy, need a job today,new jobs today">Todays Jobs</a></li>
                            <li data-name="previous" onclick="searchWithJobCategoryTypeWithTimeout()"><a href="#tab-previous" data-toggle="tab" title="Previous job, today Previous job vacancy, need a Previous job,Previous jobs">Previous Jobs</a></li>
                            <li data-name="tomorrow" onclick="searchWithJobCategoryTypeWithTimeout()"><a href="#tab-expiring-tomorrow" data-toggle="tab" title="todays Expiring job, today Expiring job vacancy, need a job today,new jobs today,job opportunities">Expiring tomorrow</a></li>
                            {{--<li><a href="#tab-govt" data-toggle="tab">Govt. Jobs</a></li>--}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content well job_category_main_div" id="home-job-category-list-sorting">
                            <div class="tab-pane active" id="tab-all" itemscope itemtype="http://schema.org/JobCategory">
                                {{--<ul class="job-category-list">--}}
                                    {{--@foreach($jobCategories as $k=>$v)--}}
                                    {{--<li>--}}
                                        {{--<a href="javascript:void(0)" class="search_by_category" data-id="{{$v->id}}">--}}
                                            {{--<img src="{{asset('resources/assets/home/img/cat-icons/'.$v->icon_name)}}" />--}}
                                            {{--<label itemprop="jobname">{{$v->category_name}}</label>--}}
                                            {{--<span class="count-job" itemprop="jobcount">({{$v->count}})</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--@endforeach--}}

                                {{--</ul>--}}
                                @foreach($jobCategories as $k=>$v)
                                    <div class="col-md-4 category_show">

                                        <a href="javascript:void(0)" class="search_by_category" data-id="{{$v->id}}" data-title="{{$v->category_name}}" title="{{$v->category_name}} , find a job, job opportunities, job search, job category, job circular, best Profession for me" >

                                            <img src="{{asset('resources/assets/home/img/cat-icons/'.$v->icon_name)}}" style="" alt="{{$v->category_name}}" />
                                            <label itemprop="jobname" style="float: left;padding-top: 6px;padding-left: 6px; cursor: pointer;">{{$v->category_name}}</label>
                                           <span class="count-job" itemprop="jobcount" style="position: absolute;top: 20px;right: 13px;">({{$v->count}})</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <hr />
                <div class="row clearfix">
                    <div class="col-md-12">
                        <h4 class="hot-title"><img src="{{asset('resources/assets/home/img/flame.png')}}" width="18" />Premium Jobs</h4>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <section class="main" itemscope itemtype="http://schema.org/PremiumJobs">

                                    @foreach($companyWithPremiumJobs as $k=>$v)
                                    <article>
                                        <div class="hot-img">
                                            @if($v["companyImage"]!='')
                                                <img src="{{URL::to('public/uploaded/company-image/'.$v["companyImage"]->image_name)}}" class="img-responsive"  itemprop="companyimage" alt="{{$v->name_of_company}}"/>
                                                @else
                                                <img src="http://via.placeholder.com/150x150" class="img-responsive" alt="{{$v->name_of_company}}" />
                                            @endif


                                        </div>
                                        <div class="hot-details">
                                            <h5 itemprop="companyname">{{$v->name_of_company}}</h5>



                                            <ul class="show-list">
                                                @foreach($v["premiumJobPost"] as $key=>$value)
                                                    @if($key<2)
                                                <li>
                                                    <a href="{{URL::to("jobDetails/".HomeController::urlFixer($value->job_title).'/'.$value->id."/".$v->id)}}" title="{{$v->name_of_company}} {{substr($value->job_title,0,25)}}" target="_blank"><i class="fa fa-caret-right" itemprop="url"></i>{{substr($value->job_title,0,25)}}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>

                                                @if(sizeof($v["premiumJobPost"])>2)
                                            <div class="hover-show">
                                                <ul class="show-list">
                                                    @foreach($v["premiumJobPost"] as $key=>$value)
                                                        @if($key>2)
                                                    <li>
                                                        <a href="{{URL::to("jobDetails/".HomeController::urlFixer($value->job_title).'/'.$value->id."/".$v->id)}}" target="_blank"><i class="fa fa-caret-right" itemprop="url"></i>{{substr($value->job_title,0,25)}}</a>
                                                    </li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </div>
                                                @endif


                                        </div>
                                    </article>
                                    @endforeach

                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <a href="{{URL::to('women-online-jobs')}}" title="online job for woman" class="woman_job" id="woman_job_btn">
                    <span>Online Jobs </span><br>
                    <span style="position: absolute; top: 22px; right: 55px;">For Women</span>
                </a>
                <a href="{{URL::to('handicap-jobs')}}" class="woman_job" id="handicap_job_btn">
                    <span>Jobs For</span><br>
                    <span style="position: absolute; top: 22px; right: 27px;">Handicapped</span>
                </a>
                <a href="{{URL::to('overseas-jobs')}}" title="overseas jobs for bangladeshi citizen" class="woman_job" id="overseas_job_btn">
                    {{--<span>Overseas</span><br>--}}
                    {{--<span style="position: absolute; top: 22px; right: 27px;">Jobs</span>--}}
                </a>
                <div class="panel panel-info panel-cstm shadow" itemscope itemtype="http://schema.org/RecentJobs">
                    <div class="panel-heading">
                        <h3 class="panel-title" title="Bangladesh government job">Govt. Jobs</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($govtJobList as $k=>$v)
                                <a href="{{$v->url}}" target="_blank" class="list-group-item" title="{{$v->url}}">{{$v->job_title}}</a>
                            @endforeach
                        </ul>
                    </div>
                    {{--<div class="panel-footer">--}}
                        {{--<a href="{{URL::to('findjobs')}}" class="a-more">More &nbsp;<i class="fa fa-angle-right"></i></a>--}}
                    {{--</div>--}}
                </div>
                <div class="alert-box-info shadow" itemscope itemtype="http://schema.org/JobAlert">
                    <!-- <h3>Get Best match jobs on your mail.No registration needed</h3> -->
                    <a class="btn btn-info btn-alert" data-toggle="modal" data-target="#jobAlertModal" title="Create Job Alert" id="job-alert-btn"  href="javascript:void(0)">Create Job Alert</a>
                    {{--<button class="btn btn-info btn-alert">Create Job Alert</button>--}}
                </div>
                <div class="panel panel-info panel-cstm shadow" itemscope itemtype="http://schema.org/RecentJobs">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Recent Jobs</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($recentJob as $k=>$v)
                            <a href="{{URL::to('jobDetails/'.HomeController::urlFixer($v->job_title).'/'.$v->id.'/'.$v->company_id)}}" target="_blank" class="list-group-item" title="{{substr($v->job_title,0,25)}}">{{substr($v->job_title,0,25)}}</a>
                            @endforeach
                        </ul>
                        <!-- <hr class="hr-cstm"> -->

                    </div>
                    <div class="panel-footer">
                        <a href="{{URL::to('findjobs')}}" class="a-more">More &nbsp;<i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="panel panel-info panel-cstm shadow">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Advertisement</h3>
                    </div>
                    <div class="panel-body clearfix">
                        <ul class="ad-list">
                            <li>
                                <img src="{{URL::to('resources/assets/home/img/clients/kems.png')}}" class="img-responsive"  alt="kems"/>
                                <a href="http://www.kemsgroup.com/" target="_blank">KEMS GROUP</a>
                            </li>
                            <li>
                                <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                                <a href="#" target="_blank">xxx</a>
                            </li>
                            <li>
                                <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                                <a href="#" target="_blank">xxx</a>
                            </li>
                            <li>
                                <img src="http://via.placeholder.com/150x150" class="img-responsive" />
                                <a href="#" target="_blank">xxx</a>
                            </li>
                        </ul>
                        <!-- <hr class="hr-cstm"> -->

                    </div>
                    <div class="panel-footer">
                        <a href="#" class="a-more">More &nbsp;<i class="fa fa-angle-right"></i></a>
                    </div>
                </div>

                <div class="advert-areas">
                  <a href="http://www.bgttc.gov.bd/" title="BANGLADESH-GERMAN TECHNICAL TRAINING CENTRE">
                    <img src="{{asset('public/uploaded/advertisement/BANGLADESH-GERMAN TECHNICAL TRAINING CENTRE.jpg')}}" target="_blank" class="img-responsive" alt="BANGLADESH-GERMAN TECHNICAL TRAINING CENTRE.jpg" />
                  </a>
                  <a href="http://www.bkttcdhaka.gov.bd/" title="Bangladesh Korea Technical Training Center, Dhaka">
                      <img src="{{asset('public/uploaded/advertisement/Bangladesh Korea Technical Training Center.png')}}" target="_blank" class="img-responsive" alt="Bangladesh Korea Technical Training Center, Dhaka" />
                  </a>

                  <a href="http://mawts.org/" title="Mawts">
                    <img src="{{asset('public/uploaded/advertisement/Mawts.png')}}" target="_blank" class="img-responsive" alt="Mawts" />
                  </a>
                  <a href="http://www.ucepbd.org/" title="ucep bangladesh">
                    <img src="{{asset('public/uploaded/advertisement/ucep bangladesh.png')}}" target="_blank" class="img-responsive" alt="ucep bangladesh" />
                  </a>

                </div>


            </div>
        </div>
    </div>

    <!-- <div class="block block-pd-sm" style="background: #eaeaea;padding-bottom:100px;">

    </div> -->
    <div class="block block-pd-sm about-home-bg">
        <div class="container">
            <div class="row">
                <h2 class="text-center" style="margin-bottom:30px;color:  #fff;"><span style="background: rgba(0, 0, 0, 0.66);padding: 2px 30px;border-radius: 7px;">Why us?</span></h2>
                <div class="col-md-12">
                    <div class="carousel carousel-showmanymoveone slide" id="carousel123">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-md-3 col-sm-6 col-xsx-6">
                                    <div class="serviceBox">
                                        <div class="service-icon">
                                            <span><i class="fa fa-search"></i></span>
                                        </div>
                                        <div class="service-content">
                                            <h1 class="title" title="Brings out the best candidate">Brings out the best candidate</h1>
                                            <p class="description">
                                                Valerejobs assists each candidate to assess their own strength when they submit their Core
                                                Competencies online at Valerejobs. This requisite assists one to focus in their areas of
                                                excellence and to build a better....
                                            </p>

                                            <a href="{{URL::to('whyus')}}" class="read-more fa fa-plus" data-toggle="tooltip" title="Read More"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-md-3 col-sm-6 col-xsx-6">
                                    <div class="serviceBox green">
                                        <div class="service-icon">
                                            <span><i class="fa fa-arrows-alt"></i></span>
                                        </div>
                                        <div class="service-content">
                                            <h1 class="title" title="Candidates Matching">Candidates Matching</h1>
                                            <p class="description">
                                                With quality, Valerejobs also matches the precise candidate for an employer, by evaluating all the
                                                needs of the employer and cross checking it with the qualifications of the candidate. This practice
                                                evaluates candidates based on merit...
                                            </p>
                                            <a href="{{URL::to('whyus#1')}}" class="read-more fa fa-plus" data-toggle="tooltip" title="Read More"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="serviceBox orange">
                                        <div class="service-icon">
                                            <span><i class="fa fa-female"></i></span>
                                        </div>
                                        <div class="service-content">
                                            <h1 class="title" title="Women Empowerment">Women Empowerment</h1>
                                            <p class="description">
                                                In South East Asia more than 84 million educated women presently remain un-employed at home, while
                                                about 1.70 million women join this cycle each year. Valerejobs offers interactive workshops to
                                                develop all types of skills...
                                            </p>
                                            <a href="{{URL::to('whyus#2')}}" class="read-more fa fa-plus" data-toggle="tooltip" title="Read More"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="serviceBox green">
                                        <div class="service-icon">
                                            <span style="background: #22b8cf;"><i class="fa fa-trophy"></i></span>
                                        </div>
                                        <div class="service-content">
                                            <h1 class="title" title="Keeps Next Generation up to date">Keeps Next Generation up to date</h1>
                                            <p class="description">
                                                To remain a progressive and innovative 'Next-Generation' global platform for jobs and building careers,
                                                Valerejobs also has a window for 'Business News' and ‘Forum' which helps candidates to...
                                            </p>
                                            <a href="{{URL::to('whyus#3')}}" class="read-more fa fa-plus" data-toggle="tooltip" title="Read More"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="serviceBox blue">
                                        <div class="service-icon">
                                            <span style="background: #183c7a;"><i class="fa fa-graduation-cap"></i></span>
                                        </div>
                                        <div class="service-content">
                                            <h1 class="title" title="Career Development">Career Development</h1>
                                            <p class="description">
                                                At Valerejobs we help candidates to develop and excel in their career by facilitating them with the skills,
                                                opportunities and values of our passion for excellence...
                                            </p>
                                            <a href="{{URL::to('whyus#4')}}" class="read-more fa fa-plus" data-toggle="tooltip" title="Read More"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel123" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                        <a class="right carousel-control" href="#carousel123" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content -->
    <!-- Call out block -->
    @include('home.layout.client')


</div>





    <!-- /content -->






@include('home.layout.footer')

<script>

    function searchWithJobCategoryType() {
        var jobType=$("#home_job_type").val();
        var jobCategory=$('ul#home-job-tab-division').find('li.active').data('name');

        $(".loader-container").show();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            url: BASE_URL + "/api/partial/searchJobCountWithTypeCategory",
            data: {
                jobType:jobType,
                jobCategory:jobCategory
            },
            success: function (data) {
                $("#home-job-category-list-sorting").html(data);
                $(".loader-container").hide();
            }
        });
    }

    $(".search-with-job-category-type").on("change",function () {
        searchWithJobCategoryType();
    });

    function searchWithJobCategoryTypeWithTimeout() {
        $(".loader-container").show();
        setTimeout(function(){
            searchWithJobCategoryType();
        }, 500);

    }
</script>


<script>
    $("#home-job-category-list-sorting").on("click",".search_by_category",function () {
        var categoryId=$(this).attr("data-id");
        var jobTitle=$(this).attr("data-title");

        jobTitle=jobTitle.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g," ");
        jobTitle=jobTitle.replace(/\s{2,}/g," ");
        jobTitle=jobTitle.trim();

        jobTitle = jobTitle.split(' ').join('-');
        jobTitle = jobTitle.toLowerCase();
        var jobType=$("#home_job_type").val();
        var url=BASE_URL+"/findjobs/"+jobTitle+"?jobCategory="+categoryId+"&jobType="+jobType;
        redirectUrl(url)
    })
</script>



<script>
    $("#search_by_header_form").on("click",function () {
        var searchAll=$("#header_form_all").val();
        var location=$("#header_form_location").val();
        var type=$("#header_form_type").val();
        var url='';
        if(type=='resume'){
            url=BASE_URL+"/findresume?searchBy="+searchAll+"&location="+location;
        }else if(type=='job'){
            url=BASE_URL+"/findjobs?searchBy="+searchAll+"&location="+location;
        }else{
            alert("Unknown request");
            return false;
        }

        redirectUrl(url)
    })
</script>
<script>
    (function(){
        // setup your carousels as you normally would using JS
        // or via data attributes according to the documentation
        // https://getbootstrap.com/javascript/#carousel
        $('#carousel123').carousel({ interval: 10000 });

    }());

    (function(){
        $('.carousel-showmanymoveone .item').each(function(){
            var itemToClone = $(this);

            for (var i=1;i<4;i++) {
                itemToClone = itemToClone.next();

                // wrap around if at end of item collection
                if (!itemToClone.length) {
                    itemToClone = $(this).siblings(':first');
                }

                // grab item, clone, add marker class, add to collection
                itemToClone.children(':first-child').clone()
                    .addClass("cloneditem-"+(i))
                    .appendTo($(this));
            }
        });
    }());
</script>



</body>

</html>
