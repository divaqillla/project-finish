// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

// Bar Chart Example
// var ctx = document.getElementById("myBarChart");
// var myLineChart = new Chart(ctx, {
//     type: "bar",
//     data: {
//         labels: ["Saif", "Iswanto", "Adi", "Chafiz", "Almaarif", "Wahyu"],
//         datasets: [
//             {
//                 label: "Revenue",
//                 backgroundColor: "rgba(2,117,216,1)",
//                 borderColor: "rgba(2,117,216,1)",
//                 data: [10, 20, 30, 40, 50, 60],
//             },
//         ],
//     },
//     options: {
//         scales: {
//             xAxes: [
//                 {
//                     time: {
//                         unit: "month",
//                     },
//                     gridLines: {
//                         display: false,
//                     },
//                     ticks: {
//                         maxTicksLimit: 6,
//                     },
//                 },
//             ],
//             yAxes: [
//                 {
//                     ticks: {
//                         min: 0,
//                         max: 100,
//                         stepSize: 20, // Menentukan langkah antara label
//                         callback: function (value) {
//                             return value + "%";
//                         },
//                     },
//                     gridLines: {
//                         display: true,
//                     },
//                 },
//             ],
//         },
//         legend: {
//             display: false,
//         },
//     },
// });
