<!-- ======== @Region: #footer ======== -->
<!-- ======== @Region: #footer ======== -->

<input type='hidden' value="{{URL::to('/')}}" id="base_url" />
<input type="hidden" value="{{csrf_token()}}" name="_token"/>
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
          <p style="margin-bottom: 30px;">Post/Manage resume and apply to right jobs in the easiest way</p><br>
          <a href="{{asset('register/employee')}}" class="btn-create-acc">Create Account</a>
        </div><div class="option-single">
          <i class="fa fa-user"></i>
          <h4>Employers</h4>
          <p style="margin-bottom: 30px;">Find the best candidates in the fastest way</p><br>
          <a href="{{asset('register/employer')}}" class="btn-create-acc">Create Account</a>
        </div>
      </div>
    </div>
  </div>
</div>

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

{{--<script src="{{asset('resources/assets/home/contactform/contactform.js')}}"></script>--}}

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
    var BASE_URL=$("#base_url").val();
    var CSRF_TOKEN=$('input[name=_token]').val();
</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "http://valerejobs.com",
  "name": "Valerejobs",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+880-1798039767",
    "contactType": "Help Line"
  }
}
</script>