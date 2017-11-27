google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Element', 'Доля', {role: 'style'}, 'value'],
        ['PayPal ', tcBillboard.config.payment.PayPal, 'gold', 2],
        ['Банковский перевод ', tcBillboard.config.payment.bank, 'color: #e5e4e2', 1]
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2]);

    var options = {
        title: "Доля способов оплаты",
        //width: 600,
        height: 120,
        bar: {groupWidth: "85%"},
        legend: { position: "none" },
        //isStacked: 'percent',
        hAxis: {
            minValue: 0,
            //ticks: [0, .3, .6, .9, 1]
        }
    };
    var chart = new google.visualization.BarChart(document.getElementById("tcbillboard-chart"));
    chart.draw(view, options);

    google.visualization.events.addListener(chart, 'select', function () {
        var selection = chart.getSelection();
        if (selection.length) {
            var row = selection[0].row;
            var value = data.getValue(row, 3);

            document.querySelector('#tcbillboard-form-orders-chart').value = data.getValue(row, 3);
            document.getElementById('tcbillboard-form-orders-chart').click();
        }
    });
}
