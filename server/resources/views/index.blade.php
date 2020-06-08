@component('header')
@endcomponent

@yield('content')

@component('footer')
@endcomponent

<!-- App javascript -->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/feather.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('js/manage.js')}}"></script>

<!--Add script-->
@stack('scripts')
