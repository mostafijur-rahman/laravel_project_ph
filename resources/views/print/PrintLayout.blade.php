<!DOCTYPE html>
<html>
    <head>
        <title>{{$title}} | {!! config('app.name') !!}</title>
        <meta charset="utf-8">
        <meta content="ie=edge" http-equiv="x-ua-compatible">
        <link rel="icon" href="{{ asset('storage/setting/default_favicon.png') }}" type="image/x-icon" />
        <link rel="stylesheet" href="{{ URL::to('assets/print/maince5p.css?version=4.4.1') }}" >
        <style>
            .label{ color: black}
        </style>
        <style>
            @media print {
                @page {
                    size: auto
                }
            }
            .table-bordered td {
                border: 1px solid black !important;
            }
            .table th, .table td {
                padding: 2px;
            }
            h6 {
                padding: 8px;
            }
            thead tr, tfoot tr {
                font-weight: bold;
            }
        </style>
    </head>
    <body class="menu-position-top with-content-panel">
        <div class="all-wrapper">
            <div class="layout-w">
                <div class="content-box">
                    @include('print.print_header')
                    @yield('body')
                    @include('print.print_footer')
                </div>
            </div>
        </div>
    </body>
</html>
