<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>BHW Information System</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('resources/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <!-- bootstrap datepicker -->
    <link href="{{ asset('resources/plugin/datepicker/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/plugin/Lobibox/lobibox.css') }}">
    <title>
        @yield('title','Home')
    </title>

    <!--DATE RANGE-->
    <link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <!--CHOOSEN SELECT -->
    <link href="{{ asset('resources/plugin/chosen/chosen.css') }}" rel="stylesheet">
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/plugin/xeditable/css/bootstrap-editable.css') }}" rel="stylesheet">
    @yield('css')
    <style>
        body {
            background: url('{{ asset('resources/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        .loading {
            opacity:0.4;
            background:#ccc url('{{ asset('resources/img/spin.gif')}}') no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:999999999;
            display: none;
        }
        .form-control-static {
            min-height: 0px;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 2px;
        }
        .form-control-select {
            min-height: 0px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 2px;
        }
        .table tr td {
            vertical-align: middle !important;
        }
        .attainment label {
            margin-bottom: 0px;
            font-size:0.9em;
        }
        label {
            cursor: pointer;
        }

        .label {
            color:#1c2d3f;
            font-size:0.9em;
            float:left;
            margin-top:6px;
        }
        .input {
            overflow: hidden;
            display: block;
            padding: 0 4px 0 10px
        }
        .input input {
            width: 100%;
        }
        .btn-flat {
            border-radius: 0;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            border-width: 1px;
        }
    </style>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ asset('resources/assets/js/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="header" style="background-color:#2F4054;padding:10px;">
        <div class="container">
            <div class="pull-left">
                <span class="title-info">Welcome,</span> <span class="title-desc">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
            </div>

            <div class="pull-right">
                <span class="title-info">Date:</span> <span class="title-desc">{{ date('M d, Y') }}</span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="header" style="background-color:#77ab59;padding:15px;">
        <div class="container">
            <img src="{{ asset('resources/img/banner.png') }}" class="img-responsive" />
        </div>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Members <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('member/add') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Member</a></li>
                        <li><a href="{{ URL::to('member/list') }}"><i class="fa fa-table"></i>&nbsp;&nbsp; Member List</a></li>
                        @if(Auth::user()->user_priv==1)
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('check') }}"><i class="fa fa-check"></i>&nbsp;&nbsp; Check PNG Files</a></li>
                        @endif
                    </ul>
                </li>
                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="loading"></div>
    @yield('content')
    <div class="clearfix"></div>
</div> <!-- /container -->
<footer class="footer">
    <div class="container">
        <p>All Rights Reserved 2017 | Version 1.0</p>
    </div>
</footer>


        <!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/jquery-validate.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('resources/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script>var loadingState = '<center><img src="{{ asset('resources/img/spin.gif') }}" width="150" style="padding:20px;"></center>'; </script>
<!-- bootstrap datepicker -->
<script src="{{ asset('resources/plugin/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('resources/assets/js/script.js') }}?v=1"></script>
<script src="{{ asset('resources/assets/js/form-justification.js') }}"></script>
<script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
<!-- DATE RANGE SELECT -->
<script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
<!-- NUMERAL JS -->
<script src="{{ asset('resources/assets/js/Numeral-js/src/numeral.js') }}"></script>
<!-- SELECT CHOOSEN -->
<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}"></script>
<script src="{{ asset('resources/plugin/chosen/chosen.jquery.js') }}"></script>
<!-- CKEDITOR -->
<script src="{{ asset('resources/plugin/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('resources/plugin/ckeditor/adapters/jquery.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ asset('resources/plugin/xeditable/js/bootstrap-editable.min.js') }}"></script>
@yield('plugin')
<script>
    $('#reservation').daterangepicker();
    $('.daterange').daterangepicker();
    $('.chosen-select').chosen({width: "100%"});
    $('.chosen-select-static').chosen();
    $('.form-submit').on('submit',function(){
        $('.btn-submit').attr('disabled',true);
    });
</script>
@section('js')

@show
</body>
</html>