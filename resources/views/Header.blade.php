


<head>
    <title>@yield('title')</title>

{{--    <link  href="{{ URL::asset('/public/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css' />--}}
    <link  href="/public/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link  href="/public/css/welcome.css" rel='stylesheet' type='text/css' />
    <link  href="/public/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<!--[if lt IE 9]>--}}
    {{--<!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->--}}
    {{--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}
    {{--<![endif]-->--}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css') }}">



    <!-- start plugins -->

    <script type="text/javascript"  src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript"  src="{{ URL::asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>






</head>
<body>
@section('nav')
   <div class="container-fluid">
       <div class="row text-info" id="nav-left">
           <ul class="list-inline pull-left col-sm-offset-2">
               <li>Sales</li>
               <li>Orders</li>
               <li>Inventory</li>
               <li>Reconciliation</li>
               <li>Accounting</li>
               <li>Summery</li>
           </ul>
           <ul class="list-inline pull-right col-sm-offset-1">
               <li>san</li>
               <li>san</li>
           </ul>
       </div>

   </div>
@show
<div class="container-fluid">
    <div class="row">
        {{--<div class="col-sm-2" id="sidebar">--}}
{{--            @yield("sidebar")--}}
        {{--</div>--}}
        <div class="col-sm-offset-1 col-sm-10">
            <div class="row ">
                <ol class="breadcrumb " id="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active">Data</li>
                </ol>
            </div>
            <div class="row">
                @yield('content')
            </div>

        </div>
    </div>

</div>
</body>
</html>