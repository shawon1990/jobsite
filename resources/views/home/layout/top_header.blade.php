<!-- ======== @Region: #navigation ======== -->
<style>
  .goog-te-banner-frame.skiptranslate {display: none !important;}

</style>
<div id="navigation" class="wrapper">
  <!--Hidden Header Region-->
  <div class="header">
    <div class="header-inner container">
      <div class="row">
        <div class="col-md-4">
          <!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->
          <a class="navbar-brand" href="{{asset('/')}}" title="valerejobs.com" aria-label="valerejobs Home">
            <img src="{{asset('resources/assets/home/img/logo.png')}}" alt="Logo" title="valerejobs.com logo" />
            <div class="tlt passion-txt" data-in-effect="rollIn" data-in-sequence="true" data-out-effect="rollOut" data-in-sequence="true" >Passion to visualize</div>
          </a>

        </div>


        <!--header rightside-->
        <div class="col-md-7 top-right-block">
          <!--user menu-->
          <ul class="list-inline user-menu pull-right">
            <!-- <li class="hidden-xs">
              <div class="switch">
                <input type="radio" class="switch-input" name="view" value="week" id="week" checked>
                <label for="week" class="switch-label switch-label-off">Week</label>
                <input type="radio" class="switch-input" name="view" value="month" id="month">
                <label for="month" class="switch-label switch-label-on">Month</label>
                <span class="switch-selection"></span>
              </div>
            </li> -->

            <li class="hidden-xs">
              <div class="helpline">
                <i class="fa fa-phone"></i>
                <div class="helpline-extended" title="valerejobs.com phone">
                  +880-1798039767
                </div>
              </div>
            </li>
            @if(Auth::user())
              <li class="hidden-xs"><i class="fa fa-sign-in fa-2x text-primary"></i>
                <a href="{{asset('/login')}}" title="valerejobs.com login" class="text-uppercase">{{Auth::user()->email}}</a>
              </li>
              @else
            <li class="hidden-xs"><i class="fa fa-edit fa-2x text-primary"></i> <a data-toggle="modal" data-target="#myModal" title="valerejobs.com register" href="#" class="text-uppercase">Register</a></li>
            <li class="hidden-xs"><i class="fa fa-sign-in fa-2x text-primary"></i> <a href="{{asset('/login')}}" title="valerejobs.com login" class="text-uppercase">Login</a></li>
            @endif
            <!-- <li class="hidden-xs">
              <i class="fa fa-phone-square fa-2x text-primary"></i>
              <a href="#" style="color:#000;">Helpline-+88 017177600000</a>
            </li> -->

          </ul>
        </div>
        <div id="google_translate_element" class="col-md-1"></div><script type="text/javascript">
              function googleTranslateElementInit() {
                  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
              }
        </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
      </div>
    </div>
  </div>
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <!--mobile collapse menu button-->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav" id="main-menu">
          <li class="visible-xs"><a data-toggle="modal" data-target="#myModal" title="valerejobs.com register" href="#" class="text-uppercase">Register</a></li>
          <li class="visible-xs"><a href="{{asset('/login')}}" title="valerejobs.com login" class="text-uppercase">Login</a></li>
          <li class="icon-link">
            <a href="{{asset('/')}}"><i class="fa fa-home" title="valerejobs.com"  style="margin-top: 18px;"></i></a>
          </li>

          <li><a href="{{asset('findjobs')}}" title="Find a Jobs, jobs in bangladesh, online jobs, job circular in bangladesh, recent job news in bangladesh, find job in bangladesh">Find Jobs</a></li>
          <li><a href="{{asset('findresume')}}" title="Find Resume, find smart resume, find smart cv, find cv, find modern cv, free resume, resume services, resume">Find Resume</a></li>
          <li><a href="{{asset('create/post-a-job')}}" title="post a job, job postings, job posting sites, job posting, ">Post A Job</a></li>
          <li><a href="{{asset('about')}}" title="About us, about valerejobs, about jobsite in bangladesh">About us</a></li>
          <li><a href="{{asset('business-update')}}" title="business update,business news,business news today, current business news,latest business news,business articles,recent business news ">Business Update</a></li>

          {{--<li><a href="{{asset('ourResume')}}">Resume Guide</a></li>--}}
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Guide<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{asset('ourResume')}}" title="ourResume, resume guide, resume format, professional resume, best resume format, sample resume format, resume design,student resume format">Resume Guide</a></li>
              <li><a href="{{URL::to('web-guide')}}" title="web guide, web design, website design, web guide system, brand guide, guide website, web design guide, web design guidelines template">Web Guide</a></li>
              <li><a href="{{URL::to('benifits')}}" title="benifits, valerejobs benefits, employer benefits, employee benefits,">Benefits</a></li>
            </ul>
          </li>
          {{--<li><a href="{{asset('ourResume')}}">Our Resume</a></li>--}}
          <li><a href="{{asset('contact')}}" title="contact">Contact</a></li>
          <li><a href="{{asset('forum')}}" title="valerejobs forum, educational forum">Forum</a></li>
        </ul>
      </div>
    </div>
    <!--/.navbar-collapse -->
  </div>
</div>


