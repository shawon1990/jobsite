<!DOCTYPE html>
<html lang="en">
    @include('home.layout.header')
<!-- ======== @Region: body ======== -->
<body class="fullscreen-centered page-register">

<!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
<div id="background-wrapper" class="benches" data-stellar-background-ratio="0.8">
    <a href="{{route('/')}}" class="back-home"><i class="fa fa-angle-left"></i>&nbsp;&nbsp; Back</a>

    <!-- ======== @Region: #content ======== -->
    <div id="content">

        {{--<div class="header">--}}
            {{--<div class="header-inner">--}}
                {{--<!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->--}}
                {{--<a class="navbar-brand center-block logo-other" href="{{route('/')}}" title="Home" style="background-color:#fff;">--}}
                    {{--<h1 class="hidden">--}}
                        {{--<img src="{{asset('resources/assets/home/img/logo.png')}}" alt="Flexor Logo">--}}
                    {{--</h1>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default ab-panel sign-top">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Sign Up
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" id="registration-Form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                        <input type="text" id="first_name" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required autofocus style="font-size: 13px;">
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                        <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required autofocus style="font-size: 13px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required style="font-size: 13px;">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required style="font-size: 13px;">
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                        <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" required style="font-size: 13px;">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                        <input type="text" id="user_type" class="form-control" placeholder="User Type" name="user_type" value="{{$userType}}" required autofocus readonly style="font-size: 13px;">
                                    </div>
                                </div>

                                @if($userType=="employer")
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                            <input type="text" id="company_name" class="form-control" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}" required autofocus style="font-size: 13px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                            <select class="form-control" name="company_type" id="company_type">
                                                <option value="0">Select Company Type</option>
                                                @foreach($companyType as $k=>$v)
                                                <option value="{{$v->id}}">{{$v->company_type_name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    @if ($errors->has('company_type'))
                                      <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('company_type')}}</strong>
                                      </span>
                                    @endif
                                @endif


                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Terms" required>
                                        I agree to the <a href="{{route('terms')}}" target="_blank">terms and conditions</a>.
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign Me Up">
                            </fieldset>
                        </form>
                        <p class="m-b-0 m-t mb-fix text-center" style="margin-top: -12px !important;">Already signed up? <a href="{{route('login')}}">Login here</a>.</p>

                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
</div>
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

@include('home.layout.footer_script')

<script type="text/javascript">
    $(document).ready(function(){
        $('#registration-Form').submit(function() {
            $(".loader-container").show();
            return true;
        });
    });
</script>

<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-55234356-4', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>
