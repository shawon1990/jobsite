<!DOCTYPE html>
<html lang="en">
    @include('home.layout.header')

<!-- ======== @Region: body ======== -->
<body class="fullscreen-centered page-login">
<!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
<div id="background-wrapper" class="benches" data-stellar-background-ratio="0.8">
    <a href="{{route('/')}}" class="back-home"><i class="fa fa-angle-left"></i>&nbsp;&nbsp; Back</a>

    <!-- ======== @Region: #content ======== -->
    <div id="content">
        {{--<div class="header">--}}
            {{--<div class="header-inner">--}}
                {{--<!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->--}}
                {{--<a class="navbar-brand center-block logo-other" href="{{route('/')}}" title="Home">--}}
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
                        <h2 class="panel-title">
                            Login
                        </h2>
                    </div>

                    <div class="panel-body" style="padding:30px;">
                        @if ($errors->has('email'))
                            <span class="help-block alert alert-danger" style="text-align: center">
                                  <strong>{{ $errors->first('email') }}</strong>
                             </span>
                        @endif
                        <form accept-charset="UTF-8" role="form"  method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus style="font-size: 13px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                        <input id="password" type="password" class="form-control" placeholder="Password" name="password" required style="font-size: 13px;">

                                    </div>
                                </div>
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input name="remember" type="checkbox" value="Remember Me">--}}
                                        {{--Remember Me--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
                            </fieldset>
                        </form>
                            <div class="col-md-6">
                                <p class="m-b-0 m-t">Not signed up?<a data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Sign up here</a></p>
                                <p class="m-b-0 m-t"><a data-id="forgotPassword" data-type="password" class="send-missing-info" href="javascript:void(0)">Forgot password?</a></p>
                            </div>
                            <div class="col-md-6">
                                 <p class="m-b-0 m-t pull-right"><a data-id="verificationEmail" data-type="verification" class="send-missing-info" href="javascript:void(0)">Resend Verification email</a></p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
</div>

<div class="modal fade modal-choose" id="missingInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="missingInfoLabel">Forgot Password</h4>
                <p>Please type your email address</p>
                <h2 id="missingInfoModalMsg" style="font-size: 100%; background-color: #a7a7da; padding: 14px; font-weight: bold; color: springgreen; display: none;"></h2>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="missingInfoEmail" value="">
            </div>

            <button class="btn btn-lg btn-primary btn-block" data-type="" type="button" id="missingInfoSend" >SEND</button>
        </div>
    </div>
</div>
<!-- Required JavaScript Libraries -->

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

<script>
    $(".send-missing-info").on("click",function () {
        var label=$(this).attr("data-id");
        var type=$(this).attr("data-type");
        $("#missingInfoLabel").html(label);
        $("#missingInfoEmail").val("");
        $("#missingInfoModalMsg").hide();
        $("#missingInfoSend").attr("data-type",type);
        $("#missingInfoModal").modal("show");
    });

    $("#missingInfoSend").on("click",function () {
        var email=$("#missingInfoEmail").val();
        if(email==''){
            $("#missingInfoModalMsg").html("Please type your email addresss")
            $("#missingInfoModalMsg").show();
            return false;
        }else{
            var checkEmail=validateEmail(email);

            if(checkEmail==false){
                $("#missingInfoModalMsg").html("This email is invalid")
                $("#missingInfoModalMsg").show();
                return false;
            }
        }
        var type=$(this).attr("data-type");
        var url='';
        if(type=='password'){
            url="/api/send/forgot/password";
        }else{
            url="/api/send/verification/email";
        }



        $(".loader-container").show()
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            url: BASE_URL + url,
            data: {
                email:email,

            },
            success: function (data) {
                  console.log(data)
                $("#missingInfoModalMsg").html(data.responseStat.msg)
                $("#missingInfoModalMsg").show();

                setTimeout(function(){
                    $("#missingInfoModalMsg").hide();
                    }, 3000);
                if(data.responseStat.status==true){
                    setTimeout(function(){
                        $("#missingInfoModal").modal("hide");
                    }, 3000);
                }
                $(".loader-container").hide()
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
</body>
</html>
