@yield('styles')


@yield('content')

<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
<script src="{{asset('assets/admin/js/vendors/vue.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{asset('assets/admin/js/plugin.js')}}"></script>
<script src="{{asset('assets/admin/js/tag-it.js')}}"></script>
<script src="{{asset('assets/admin/js/load.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">



@yield('scripts')
