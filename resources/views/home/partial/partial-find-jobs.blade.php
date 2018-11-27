<?php use App\Http\Controllers\HomeController; ?>
<h3 class="search-header">Showing <strong><?php echo sizeof($jobResult) ?></strong> results </h3>
@foreach($jobResult as $k=>$v)
    <div class="job-single">
        <a target="_blank" href="{{URL::to('/jobDetails/'.HomeController::urlFixer($v->job_title).'/'.$v->id.'/'.$v['companyInfo']->id)}}"><h5>{{$v['companyInfo']->name_of_company}}</h5></a>
        <p class="designation">
            {{$v->job_title}}
        </p>
        <p class="others">
            <?php echo strip_tags (substr($v->qualification_skills, 0, 300)) ?>

        </p>
        <strong>Deadline: @if($v->application_deadline!=''){{date("d M Y", strtotime(@$v->application_deadline))}}@endif</strong>

        <div class="job-desc-detail">
            <div class="job-desc-inner">
                <a href="{{URL::to('/job/view/'.$v->id.'/'.$v['companyInfo']->id)}}" target="_blank" class="pull-right">Apply Now</a>
                <h4><a target="_blank" href="{{URL::to('/jobDetails/'.HomeController::urlFixer($v->job_title).'/'.$v->id.'/'.$v['companyInfo']->id)}}">{{$v['companyInfo']->name_of_company}}</a></h4>
                <div class="popover-block">
                    <span>Required Work Experience</span>
                    <p>
                        @if($v->experience_from==$v->experience_to)

                            {{$v->experience_from}} years

                            @else

                            {{$v->experience_from}} - {{$v->experience_to}} years

                        @endif

                        {{--<strong>Analyst</strong>- August 1989 to February 2015--}}
                    </p>

                </div>
                <div class="popover-block">
                    <span>No. of vacancy</span>
                    <p>
                        {{$v->no_of_vacancies}}
                    </p>

                </div>
                <div class="popover-block">
                    <span>Qualification Skill</span>
                    <p>
                        <?php echo substr(html_entity_decode($v->qualification_skills), 0, 300);  ?>
                    </p>

                </div>
                <div class="popover-block">
                    <span>Job Responsibilities & Duties</span>
                    <p>
                        <?php echo substr(html_entity_decode($v->job_responsibilities_duties), 0, 500);  ?>

                    </p>

                </div>
                <div class="popover-block">
                    <span>Application Deadline</span>
                    <p>
                        {{$v->application_deadline}}
                    </p>

                </div>
            </div>
        </div>
    </div>

@endforeach
<nav>{{ $jobResult->appends(Request::except('page'))->links() }}</nav>
<script>
    $('.pagination li a').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(data) {
                $('#find-jobs-search-result-div').html(data);
            }
        });
    });


    $(".job-single").mouseover(function() {
        $(this).children(".job-desc-detail").show();
    }).mouseout(function() {
        $(this).children(".job-desc-detail").hide();
    });
</script>
