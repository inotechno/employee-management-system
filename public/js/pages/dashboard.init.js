function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var t = document.getElementById(e).getAttribute("data-colors");
        if (t)
            return (t = JSON.parse(t)).map(function (e) {
                var t = e.replace(" ", "");
                if (-1 === t.indexOf(",")) {
                    var r = getComputedStyle(
                        document.documentElement
                    ).getPropertyValue(t);
                    return r || t;
                }
                var a = e.split(",");
                return 2 != a.length
                    ? t
                    : "rgba(" +
                          getComputedStyle(
                              document.documentElement
                          ).getPropertyValue(a[0]) +
                          "," +
                          a[1] +
                          ")";
            });
    }
}
setTimeout(function () {
    $("#subscribeModal").modal("show");
}, 2e3);
var linechartBasicColors = getChartColorsArray("stacked-column-chart");
linechartBasicColors &&
    ((options = {
        chart: {
            height: 360,
            type: "bar",
            stacked: !0,
            toolbar: { show: !1 },
            zoom: { enabled: !0 },
        },
        plotOptions: {
            bar: { horizontal: !1, columnWidth: "15%", endingShape: "rounded" },
        },
        dataLabels: { enabled: !1 },
        series: [
            {
                name: "Absen",
                data: [44, 55, 41, 67, 22, 43, 36, 52, 24, 18, 36, 48],
            },
            {
                name: "Telat",
                data: [13, 23, 20, 8, 13, 27, 18, 22, 10, 16, 24, 22],
            },
            {
                name: "Tidak Absen",
                data: [11, 17, 15, 15, 21, 14, 11, 18, 17, 12, 20, 18],
            },
        ],
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
        },
        colors: linechartBasicColors,
        legend: { position: "bottom" },
        fill: { opacity: 1 },
    }),
    (chart = new ApexCharts(
        document.querySelector("#stacked-column-chart"),
        options
    )).render());
var options,
    chart,
    radialbarColors = getChartColorsArray("radialBar-chart");
radialbarColors &&
    ((options = {
        chart: { height: 200, type: "radialBar", offsetY: -10 },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                dataLabels: {
                    name: { fontSize: "13px", color: void 0, offsetY: 60 },
                    value: {
                        offsetY: 22,
                        fontSize: "16px",
                        color: void 0,
                        formatter: function (e) {
                            return e + "%";
                        },
                    },
                },
            },
        },
        colors: radialbarColors,
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                shadeIntensity: 0.15,
                inverseColors: !1,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91],
            },
        },
        stroke: { dashArray: 4 },
        series: [67],
        labels: ["Series A"],
    }),
    (chart = new ApexCharts(
        document.querySelector("#radialBar-chart"),
        options
    )).render());
