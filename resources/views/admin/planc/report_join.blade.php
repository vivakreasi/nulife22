@extends('layouts.main')

@section('vendor_style')
    <link href="{{ asset('assets/js/vendor/morris-chart/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/vendor/ion-rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/js/vendor/ion-rangeSlider/css/ion-custom-nulife.css') }}" rel="stylesheet"/>
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    Join Plan-C (Last <span id="days">30</span> Days)
                    <span class="tools pull-right">
                        <a class="fa fa-repeat box-refresh" href="javascript:;"></a>
                        <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div><input type="text" id="range_15" value="" name="range" /></div>
                    <div id="area-chart" style="height: 280px;"></div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    Tabular View
                </header>
                <div class="panel-body">
                    <table class="table table-hover responsive" id="tbl-planc">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Join</th>
                                <th>Fly</th>
                                <th>Order PIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tableData as $item)
                                <tr>
                                    <td>{{ $item->x }}</td>
                                    <td>{{ $item->join }}</td>
                                    <td>{{ $item->fly }}</td>
                                    <td>{{ $item->pin }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    {{--<section class="panel">--}}
        {{--<div class="panel-body">--}}
            {{--<table class="table table-hover responsive nowrap" id="tbl-nulife">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>User ID</th>--}}
                    {{--<th>Name</th>--}}
                    {{--<th>Pending Transfer</th>--}}
                    {{--<th>Success Transfer</th>--}}
                    {{--<th>Total Bonus</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--</div>--}}
    {{--</section>--}}
@endsection
@section('scripts')
    <!--Morris Chart-->
    <script src="{{ asset('assets/js/vendor/morris-chart/morris.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/morris-chart/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ion-rangeSlider/js/ion.rangeSlider.js') }}"></script>
    <script type="text/javascript">
        String.prototype.format = function()
        {
            var args = arguments;

            return this.replace(/{(\d+)}/g, function(match, number)
            {
                return typeof args[number] != 'undefined' ? args[number] :
                    '{' + number + '}';
            });
        };

        function ConvertJsonToTable(parsedJson, tableId, tableClassName, linkText)
        {
            //Patterns for links and NULL value
            var italic = '<i>{0}</i>';
            var link = linkText ? '<a href="{0}">' + linkText + '</a>' :
                '<a href="{0}">{0}</a>';

            //Pattern for table
            var idMarkup = tableId ? ' id="' + tableId + '"' :
                '';

            var classMarkup = tableClassName ? ' class="' + tableClassName + '"' :
                '';

            var tbl = '<table border="1" cellpadding="1" cellspacing="1"' + idMarkup + classMarkup + '>{0}{1}</table>';

            //Patterns for table content
            var th = '<thead>{0}</thead>';
            var tb = '<tbody>{0}</tbody>';
            var tr = '<tr>{0}</tr>';
            var thRow = '<th>{0}</th>';
            var tdRow = '<td>{0}</td>';
            var thCon = '';
            var tbCon = '';
            var trCon = '';

            if (parsedJson)
            {
                var isStringArray = typeof(parsedJson[0]) == 'string';
                var headers;

                // Create table headers from JSON data
                // If JSON data is a simple string array we create a single table header
                if(isStringArray)
                    thCon += thRow.format('value');
                else
                {
                    // If JSON data is an object array, headers are automatically computed
                    if(typeof(parsedJson[0]) == 'object')
                    {
                        headers = array_keys(parsedJson[0]);

                        for (var i = 0; i < headers.length; i++)
                            thCon += thRow.format(headers[i]);
                    }
                }
                th = th.format(tr.format(thCon));

                // Create table rows from Json data
                if(isStringArray)
                {
                    for (var i = 0; i < parsedJson.length; i++)
                    {
                        tbCon += tdRow.format(parsedJson[i]);
                        trCon += tr.format(tbCon);
                        tbCon = '';
                    }
                }
                else
                {
                    if(headers)
                    {
                        var urlRegExp = new RegExp(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig);
                        var javascriptRegExp = new RegExp(/(^javascript:[\s\S]*;$)/ig);

                        for (var i = 0; i < parsedJson.length; i++)
                        {
                            for (var j = 0; j < headers.length; j++)
                            {
                                var value = parsedJson[i][headers[j]];
                                var isUrl = urlRegExp.test(value) || javascriptRegExp.test(value);

                                if(isUrl)   // If value is URL we auto-create a link
                                    tbCon += tdRow.format(link.format(value));
                                else
                                {
                                    if(value){
                                        if(typeof(value) == 'object'){
                                            //for supporting nested tables
                                            tbCon += tdRow.format(ConvertJsonToTable(eval(value.data), value.tableId, value.tableClassName, value.linkText));
                                        } else {
                                            tbCon += tdRow.format(value);
                                        }

                                    } else {    // If value == null we format it like PhpMyAdmin NULL values
                                        tbCon += tdRow.format(italic.format(value).toUpperCase());
                                    }
                                }
                            }
                            trCon += tr.format(tbCon);
                            tbCon = '';
                        }
                    }
                }
                tb = tb.format(trCon);
                tbl = tbl.format(th, tb);

                return tbl;
            }
            return null;
        }

        function array_keys(input, search_value, argStrict)
        {
            var search = typeof search_value !== 'undefined', tmp_arr = [], strict = !!argStrict, include = true, key = '';

            if (input && typeof input === 'object' && input.change_key_case) { // Duck-type check for our own array()-created PHPJS_Array
                return input.keys(search_value, argStrict);
            }

            for (key in input)
            {
                if (input.hasOwnProperty(key))
                {
                    include = true;
                    if (search)
                    {
                        if (strict && input[key] !== search_value)
                            include = false;
                        else if (input[key] != search_value)
                            include = false;
                    }
                    if (include)
                        tmp_arr[tmp_arr.length] = key;
                }
            }
            return tmp_arr;
        }
    </script>
    <script type="text/javascript">
        area = Morris.Area({
            element: 'area-chart',
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            parseTime: false,
            fillOpacity:.5,
            data: {!! $jsonData !!},
            lineColors:['#4EC9B4','#81CDEA','#FFEA80'],
            xkey: 'x',
            ykeys: ['join','fly','pin'],
            labels: ['Join','Fly','PIN'],
            pointSize: 4,
            lineWidth: 1,
            hideHover: 'auto'

        });

        $("#range_15").ionRangeSlider({
            type: "single",
            grid: true,
            min: 3,
            max: {!! $maxrange !!},
            from: 30,
            postfix: " days",
            onChange: function (data) {
                console.log("onChange");
            },
            onFinish: function (data) {
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: "{{ route('admin.ajax.planc.join.report') }}/"+ data.from
                })
                    .done(function( xdata ) {
                        area.setData(xdata);
                        var jsonHtmlTable = ConvertJsonToTable(xdata, 'tbl-planc', null, null);
                        $('#tbl-planc tbody').html(jsonHtmlTable.split("<tbody>").pop().split("</tbody>").shift());
                    })
                    .fail(function() {
                        alert( "error occured" );
                    });
            }
        });

        var slider = $("#range_15").data("ionRangeSlider");

        $("#range_15").on("change", function () {
            var $this = $(this),
            value = $this.prop("value");
            $('#days').html(value);
        });

        $(".box-refresh").on("click", function () {
            $('#days').html('30');
            slider.update({
                from: 30
            });

            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "{{ route('admin.ajax.planc.join.report') }}/30"
            })
                .done(function( xdata ) {
                    area.setData(xdata);
                    var jsonHtmlTable = ConvertJsonToTable(xdata, 'tbl-planc', null, null);
                    $('#tbl-planc tbody').html(jsonHtmlTable.split("<tbody>").pop().split("</tbody>").shift());
                })
                .fail(function() {
                    alert( "error occured" );
                });

        })
    </script>
@endsection