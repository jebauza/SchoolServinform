<!DOCTYPE html>
<html>

@include('sections.head')

<body class="antialiased">
    <div id="app" class="container-fluid" style="margin-top: 30px">

        {{-- <App basepath="{{route('web.basepath')}}"></App> --}}

        <example-component></example-component>

    </div>
    <!-- ./wrapper -->

    @include('sections.script')

</body>

</html>
