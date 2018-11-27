<input type='hidden' value="{{URL::to('/')}}" id="base_url" />
<input type="hidden" value="{{csrf_token()}}" name="_token"/>
<!-- ======== @Region: #footer ======== -->
<!-- ======== @Region: #footer ======== -->

<div class="modal fade modal-choose" id="jobAlertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="jobAlertLabel">Create Job Alert</h4>
                <p>Please type your email address</p>
                <h2 id="jobAlertModalMsg" style="font-size: 100%; background-color: #a7a7da; padding: 14px; font-weight: bold; color: springgreen; display: none;"></h2>
            </div>
            <div class="modal-body">
                <label>Email Address</label>
                <input type="text" class="form-control" id="jobAlertEmail" value="">
                <label>Job Category</label>
                <select id="jobAlertJobCategory" class="select_new form-control" style="width: 100%" multiple>
                       @if(isset($jobCategories))
                        @foreach($jobCategories as $k=>$v)
                        <option value="{{$v->id}}">{{$v->category_name}}</option>
                        @endforeach
                       @endif

                </select>
            </div>

            <button class="btn btn-lg btn-primary btn-block" data-type="" type="button" id="jobAlertSend" >Submit</button>
        </div>
    </div>
</div>




<footer id="footer" class="block block-bg-grey-dark">
  <div class="container">

    <div class="row clearfix footer-links" id="contact">

      <div class="col-md-3 footer-address">
        <h3 title="valerejobs address">Address</h3>
        <p>
            {{--Hashim Tower, Suit: 6D.205/1-A Tejgaon Link Road<br>--}}
            Gulshan, Dhaka-1208,Bangladesh.
            Phone:9840189<br>
            Mobile:+880-1798039767<br>
            Mail:info@valerejobs.com
        </p>
      </div>
        <div class="col-md-3 footer-employer-employee">
            <h3 title="valerejobs Job Seekers">For Job Seekers</h3>
            <ul>
                <li><a href="{{URL::to('findjobs')}}" title="valerejobs findjobs">Find Jobs</a> </li>
                <li><a href="{{URL::to('/web-guide')}}" title="valerejobs web-guid">Help</a></li>

                {{--<li><a data-toggle="modal" data-target="#myModal" href="javascript:void(0)" >Create Account</a> </li>--}}
            </ul>
            <h3 title="valerejobs employers">For Employers</h3>
            <ul>
                <li><a href="{{URL::to('create/post-a-job')}}" title="valerejobs post job">Post Jobs</a> </li>
                <li><a href="{{URL::to('findresume')}}" title="valerejobs find resume">Find Resume</a> </li>
                <li><a href="{{URL::to('/web-guide')}}" title="valerejobs help">Help</a> </li>
                {{--<li><a href="#">Create Account</a> </li>--}}
            </ul>
        </div>
        <div class="col-md-3 footer-service">
            <h3 title="valerejobs service">Our Service</h3>
            <ul>
                <li><a href="{{URL::to('ourResume')}}" title="valerejobs post job">Our Resume</a> </li>
            </ul>
            <h4>Company Information</h4>
            <ul>
                <li><a href="{{URL::to('terms')}}" title="valerejobs terms of usage">Terms of Usage</a> </li>
                {{--<li><a href="#">Career consultancy</a> </li>--}}
                <li><a href="{{URL::to('contact')}}" title="valerejobs contact">Contact</a> </li>
                {{--<li><a href="#">Partners</a> </li>--}}
                <li><a href="{{URL::to('about')}}" title="valerejobs about us">About us</a> </li>
            </ul>
        </div>

      <div class="col-md-3 footer-social-link">
          <h3>Social Links</h3>
          <ul class="foot-social">
              <li>
                  <a href="https://www.facebook.com/Valerejobsbd" target="_blank"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                  <a href="https://twitter.com/Valerejobsbd" target="_blank"><i class="fa fa-twitter"></i></a>
              </li>
              <li>
                  <a href="https://www.instagram.com/valerejobs" target="_blank"><i class="fa fa-instagram"></i></a>
              </li>
              <li>
                  <a href="https://www.linkedin.com/company/valerejobs/" target="_blank"><i class="fa fa-linkedin"></i></a>
              </li>
              <li>
                  <a href="https://plus.google.com/108955087594110250197" target="_blank"><i class="fa fa-google-plus"></i></a>
              </li>
          </ul>
      </div>

      {{--<div class="col-md-3">--}}
        {{--<h4 class="text-uppercase">--}}
          {{--Follow Us On:--}}
        {{--</h4>--}}
        {{--<!--social media icons-->--}}
        {{--<div class="social-media social-media-stacked">--}}
          {{--<!--@todo: replace with company social media details-->--}}
          {{--<a href="#"><i class="fa fa-twitter fa-fw"></i> Twitter</a>--}}
          {{--<a href="#"><i class="fa fa-facebook fa-fw"></i> Facebook</a>--}}
          {{--<a href="#"><i class="fa fa-linkedin fa-fw"></i> LinkedIn</a>--}}
          {{--<a href="#"><i class="fa fa-google-plus fa-fw"></i> Google+</a>--}}
        {{--</div>--}}
      {{--</div>--}}

    </div>

    <div class="row subfooter">
      <!--@todo: replace with company copyright details-->
      <div class="col-md-7">
        <p title="valerejobs.com">Copyright © valerejobs.com</p>

      </div>
      <div class="col-md-5">
          <div class="credits text-right">
              Build by <a href="http://dcliquebd.com/" target="_blank">D-Clique </a>and <a href="javascript:void(0)" target="_blank">Valere Enterprise</a>
          </div>
      </div>
    </div>

    <a href="#top" class="scrolltop">Top</a>

  </div>
</footer>

<!-- Modal -->
<div class="modal fade modal-choose" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Your Account</h4>
        <p>Please choose an option</p>
      </div>
      <div class="modal-body">
        <div class="option-single blue">
          <i class="fa fa-users"></i>
          <h4>Job Seekers</h4>
          <p style="margin-bottom: 30px;">Post/Manage resume and apply to right jobs in the easiest way</p>
          <a href="{{asset('register/employee')}}" class="btn-create-acc">Create Account</a>
        </div><div class="option-single">
          <i class="fa fa-user"></i>
          <h4>Employers</h4>
          <p style="margin-bottom: 30px;">Find the best candidates in the fastest way</p>
          <a href="{{asset('register/employer')}}" class="btn-create-acc">Create Account</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- floating button -->

{{--<div class="support-online">--}}
    {{--<div class="support-content">--}}
        {{--<a href="tel:0982.802.531" class="call-now" rel="nofollow">--}}
            {{--<i class="fa fa-whatsapp" aria-hidden="true"></i>--}}
            {{--<div class="animated infinite zoomIn kenit-alo-circle"></div>--}}
            {{--<div class="animated infinite pulse kenit-alo-circle-fill"></div>--}}
            {{--<span>Hotline: 0982.802.531</span>--}}
        {{--</a>--}}
    {{--</div>--}}
    {{--<a class="btn-support">--}}
        {{--<div class="animated infinite zoomIn kenit-alo-circle"></div>--}}
        {{--<div class="animated infinite pulse kenit-alo-circle-fill"></div>--}}
        {{--<i class="fa fa-user-circle" aria-hidden="true"></i>--}}
    {{--</a>--}}
{{--</div>--}}


<!-- floating button -->

<!-- Loading screen -->

<div class="loader-container" style="display: none">
    <div class="loader-div">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
</div>

<!-- Loading screen -->





<!-- Required JavaScript Libraries -->
<script src="{{asset('resources/assets/home/lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('resources/assets/home/js/jquery.sticky.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/stellar/stellar.min.js')}}"></script>
<script src="{{asset('resources/assets/home/js/jquery.fittext.js')}}"></script>
<script src="{{asset('resources/assets/home/js/jquery.lettering.js')}}"></script>
<script src="{{asset('resources/assets/home/js/jquery.textillate.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/counterup/counterup.min.js')}}"></script>

<!-- Template Specisifc Custom Javascript File -->
<script src="{{asset('resources/assets/home/js/custom.js')}}"></script>
<script src="{{asset('resources/assets/home/js/color-switcher.js')}}"></script>
<script src="{{asset('resources/assets/home/lib/select2/select2.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/"></script>--}}
{{--<script src="{{asset('resources/assets/home/contactform/contactform.js')}}"></script>--}}


<script>
    $(document).ready(function(){
        $(".show-ex").click(function(){
            $(".feature-magnify").show();
            $(".show-ex").hide();
            $(".show-less").show();
        });
        $(".show-less").click(function(){
            $(".feature-magnify").hide();
            $(".show-less").hide();
            $(".show-ex").show();
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.support-content').hide();
        $('a.btn-support').click(function(e){
            e.stopPropagation();
            $('.support-content').slideToggle();
        });
        $('.support-content').click(function(e){
            e.stopPropagation();
        });
        $(document).click(function(){
            $('.support-content').slideUp();
        });
    });
</script>
<script>
    var BASE_URL=$("#base_url").val();
    var CSRF_TOKEN=$('input[name=_token]').val();
</script>
<script>
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
<script>
    equalheight = function(container){

        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
        $(container).each(function() {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
                for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    }

    $(window).load(function() {
        equalheight('.main article');
    });


    $(window).resize(function(){
        equalheight('.main article');
    });
</script>





<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
    window.__lc = window.__lc || {};
    window.__lc.license = 9307675;
    (function() {
        var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
        lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
    });
</script>

<script>
    // (function ($) {
    //     $(function () {
    //         $(document).off('click.bs.tab.data-api', '[data-hover="tab"]');
    //         $(document).on('mouseenter.bs.tab.data-api', '[data-toggle="tab"], [data-hover="tab"]', function () {
    //             $(this).tab('show');
    //         });
    //     });
    // })(jQuery);
</script>
<script>
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {

        });
    }, 3000);
</script>

<script>
    function redirectUrl(url) {
        window.location.href=url;
    }
</script>

<script>


    $("#job-alert-btn").on("click",function () {
        $("#jobAlertEmail").val("")
        $("#jobAlertModalMsg").hide();
    })
    $("#jobAlertSend").on("click",function () {


        var email=$("#jobAlertEmail").val();
        var jobCategory=$("#jobAlertJobCategory").val();

        if(email==''||email==null){
            $("#jobAlertModalMsg").html("Please type your email addresss")
            $("#jobAlertModalMsg").show();
            return false;
        }else if(jobCategory==''||jobCategory==null) {
            $("#jobAlertModalMsg").html("Please select at least 1 job category")
            $("#jobAlertModalMsg").show();
            return false;
        }
        else {
           var checkEmail=validateEmail(email);

           if(checkEmail==false){
               $("#jobAlertModalMsg").html("This email is invalid")
               $("#jobAlertModalMsg").show();
               return false;
           }
        }


        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            url: BASE_URL + "/api/create/job/alert",
            data: {
                email:email,
                jobCategory:jobCategory
            },
            success: function (data) {
                console.log(data)
                $("#jobAlertModalMsg").html(data.responseStat.msg)
                $("#jobAlertModalMsg").show();

                setTimeout(function(){
                    $("#jobAlertModalMsg").hide();
                }, 3000);
                if(data.responseStat.status==true){

                    setTimeout(function(){

                        $("#jobAlertModal").modal("hide");
                        $("#jobAlertEmail").val("");
                        $("#jobAlertJobCategory").val(null).trigger("change");
                    }, 3000);
                }
            }


        });
    })
</script>

<script>
    function validateEmail(email)
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
</script>

<script>
    function loaderShow() {
        $(".loader-container").show();
    }

    function loaderHide() {
        $(".loader-container").hide();
    }
</script>
<script>
    $('#jobAlertJobCategory').select2({
        maximumSelectionLength: 5
    });

    $('.select_new').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
</script>