<?php
$X_AXIS = "total_bytes";
$Y_AXIS = "nprocs";


$data = Jobs::execSQLQuery($chart["series"][0]["query"]);
$query = "select uid, appname, start_time, total_bytes, nprocs, agg_perf_MB from jobs_info where total_bytes>0 and nprocs>0 and agg_perf_MB>0";

$all_data = array();
$app_names = "";

foreach ($data as $d) {
    $series_str = "";
    $series1_str = "";
    $series2_str = "";

    $req = Jobs::execSQLQuery($query . " and appname='" . $d['appname'] . "';");
    // print_r($req);
    foreach ($req as $r) {
        $series_str .= '[' . $r[$X_AXIS] . ',' . $r[$Y_AXIS] . '],';
        $series1_str .= $r[$X_AXIS] . ',';
        $series2_str .= $r[$Y_AXIS] . ',';

        // $ret = array();
        //
      // foreach($x_options as $str)
        // {
        //   $series = "";
        //   foreach ($data as $d)
        //   {
        //     $series .= $d[$str] . ',';
        //     // $series = rtrim($series, ",");
        //   }
        //   $ret[$str] = $series;
        // }
    }
    $series_str = rtrim($series_str, ",");
    $series1_str = rtrim($series1_str, ",");
    $series2_str = rtrim($series2_str, ",");

    $s1_label = $d['appname'] . '-' . $X_AXIS;
    $s2_label = $d['appname'] . '-' . $Y_AXIS;

    $all_data[$s1_label] = $series1_str;
    $all_data[$s2_label] = $series2_str;


    $app_names .= $d['appname'] . ',';
}

$json_str = json_encode($all_data);

// print_r($all_data);
// $cats_str = "";
// $series_str = "";
//
// foreach ($data as $d) {
//     $cats_str .= '\'' . $d[$chart["xAxis"]["attribute"]] . '\'' . ',';
//     $series_str .= '[' . $d[$chart["series"][0]["min"]] . ',' . ($d[$chart["series"][0]["q1"]] * 2) . ',' . $d[$chart["series"][0]["median"]] . ',' . ($d[$chart["series"][0]["q3"]] * 0.5) . ',' . $d[$chart["series"][0]["max"]] . '],';
// }
// $cats_str = rtrim($cats_str, ",");
// $series_str = rtrim($series_str, ",");
//echo $series_str;
?>
<script type="text/javascript">
    $(function () {
        $("#dv_table").insertBefore("#15-scatter-containers");
        var axisTitles = {
            "nprocs": "Number of Processes",
            "total_bytes": "Amount of Data read/written",
            "agg_perf_MB": "I/O Throughput"
        };

        $("#chart-container").toggle();
        $("#tooltip-div").toggle();
        $("#sort-button").hide();
        $("#toggle-percentage").hide();
        $("#min_max_button_div").toggle();

        var globalxmin = 0;
        var globalxmax = 0;
        var globalymin = 0;
        var globalymax = 0;


        make_chart_min_max = function (appname, xaxis, yaxis, x_scale, y_scale, chart_id, obj, xmin, xmax, ymin, ymax) {
            // var chart = $("#" + chart_id).highcharts();
            var s1_label = appname + '-' + xaxis;
            var s2_label = appname + '-' + yaxis;

            var str_s1 = obj[s1_label].split(',');
            var str_s2 = obj[s2_label].split(',');
            var ret_obj = [];

            for (var i = 0; i < str_s1.length; i++)
            {
                if (str_s1[i].length != 0 && str_s2[i].length != 0)
                {
                    var x = parseInt(str_s1[i]);
                    var y = parseInt(str_s2[i]);
                    if (x > globalxmax)
                    {
                      globalxmax = x;
                    }
                    if (x < globalxmin)
                    {
                      globalxmin = x;
                    }
                    if (y > globalymax)
                    {
                      globalymax = y;
                    }
                    if (y < globalymin)
                    {
                      globalymin = y;
                    }
                    ret_obj.push([x, y]);
                }
            }

            $("#min_max_button").attr("data-globalxmin", globalxmin);
            $("#min_max_button").attr("data-globalxmax", globalxmax);
            $("#min_max_button").attr("data-globalymin", globalymin);
            $("#min_max_button").attr("data-globalymax", globalymax);
            $("#min_max_button").attr("data-all_same", false);

            var options = {
                chart: {
                    type: 'scatter',
                    zoomType: 'xy'
                },
                title: {
                    text: appname
                },
                legend: {
                    enabled: true
                },
                xAxis: {
                    title: {
                        enabled: true,
                        text: axisTitles[xaxis]
                    },
                    type: x_scale,
                    startOnTick: true,
                    endOnTick: true,
                    showLastLabel: true,
                    labels: {
                        formatter: function () {
                          return byte_formatter_for_bytes(this, "");
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: axisTitles[yaxis]
                    },
                    type: y_scale
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbol: "url(../../img/printer2.png)"
                            }
                    }
                },
                tooltip: {
                    formatter: function() {
                      var str = "X= " + byte_formatter_str_for_bytes(this.x, "");
                      str += ", Y= " + this.y;
                      return str;
                    }
                },
                series: [{
                        name: xaxis + ' vs. ' + yaxis,
                        color: 'rgba(0, 0, 0, .5)',
                        data: ret_obj
                    }
                ]
            };

            if (y_scale == "linear")
            {
                options.yAxis.min = 0;
            }
            if (x_scale == "linear")
            {
                options.xAxis.min = 0;
            }

            options.xAxis.min = xmin;
            options.xAxis.max = xmax;
            options.yAxis.min = ymin;
            options.yAxis.max = ymax;

            $("#" + chart_id).highcharts(options);
        }


        make_chart = function (appname, xaxis, yaxis, x_scale, y_scale, chart_id, obj) {
            // var chart = $("#" + chart_id).highcharts();
            var s1_label = appname + '-' + xaxis;
            var s2_label = appname + '-' + yaxis;

            var str_s1 = obj[s1_label].split(',');
            var str_s2 = obj[s2_label].split(',');
            var ret_obj = [];

            for (var i = 0; i < str_s1.length; i++)
            {
                if (str_s1[i].length != 0 && str_s2[i].length != 0)
                {
                    var x = parseInt(str_s1[i]);
                    var y = parseInt(str_s2[i]);
                    if (x > globalxmax)
                    {
                      globalxmax = x;
                    }
                    if (x < globalxmin)
                    {
                      globalxmin = x;
                    }
                    if (y > globalymax)
                    {
                      globalymax = y;
                    }
                    if (y < globalymin)
                    {
                      globalymin = y;
                    }
                    ret_obj.push([x, y]);
                }
            }

            $("#min_max_button").attr("data-globalxmin", globalxmin);
            $("#min_max_button").attr("data-globalxmax", globalxmax);
            $("#min_max_button").attr("data-globalymin", globalymin);
            $("#min_max_button").attr("data-globalymax", globalymax);
            $("#min_max_button").attr("data-all_same", false);

            var options = {
                chart: {
                    type: 'scatter',
                    zoomType: 'xy'
                },
                title: {
                    text: appname
                },
                legend: {
                    enabled: true
                },
                xAxis: {
                    title: {
                        enabled: true,
                        text: axisTitles[xaxis]
                    },
                    type: x_scale,
                    startOnTick: true,
                    endOnTick: true,
                    showLastLabel: true,
                    labels: {
                        formatter: function () {
                          return byte_formatter_for_bytes(this, "");
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: axisTitles[yaxis]
                    },
                    type: y_scale
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbol: "url(../../img/printer2.png)"
                            }
                    }
                },
                // plotOptions: {
                //     scatter: {
                //         marker: {
                //             radius: 5,
                //             states: {
                //                 hover: {
                //                     enabled: true,
                //                     lineColor: 'rgb(100,100,100)'
                //                 }
                //             }
                //         },
                //         states: {
                //             hover: {
                //                 marker: {
                //                     enabled: false
                //                 }
                //             }
                //         }
                //     }
                // },
                tooltip: {
                    formatter: function() {
                      var str = "X= " + byte_formatter_str_for_bytes(this.x, "");
                      str += ", Y= " + this.y;
                      return str;
                    }
                },
                series: [{
                        name: xaxis + ' vs. ' + yaxis,
                        color: 'rgba(0, 0, 0, .5)',
                        data: ret_obj
                    }
                ]
            };

            if (y_scale == "linear")
            {
                options.yAxis.min = 0;
            }
            if (x_scale == "linear")
            {
                options.xAxis.min = 0;
            }

            // options.legend.enabled = false;

            $("#" + chart_id).highcharts(options);
        }

        console.log(<?php echo $json_str ?>);
        var obj = <?php echo $json_str ?>;
        var appnames = '<?php echo $app_names ?>';
        var app_arr = appnames.split(',');
        $("#15-scatter-containers").toggle();
        for (var i = 0; i < 10; i++)
        {
            var chartid = "chart-container-" + (i + 1);
            make_chart(app_arr[i], "total_bytes", "nprocs", "linear", "linear", chartid, obj);
        }
    });
</script>
