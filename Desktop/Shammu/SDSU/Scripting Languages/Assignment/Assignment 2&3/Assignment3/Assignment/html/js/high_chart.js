$(function() {
//Highcharts with mySQL and PHP - Ajax101.com

    var name = [];
    var numberSold = [];
    var switch1 = true;
    $.get('data_chart.php', function(data) {

        data = data.split('/');
        for (var i in data) {
        if (switch1 == true) {
            name.push(data[i]);
            switch1 = false;
        } else {
            numberSold.push(parseFloat(data[i]));
            switch1 = true;
        }

    }
    name.pop();

    $('#chart').highcharts({
        chart : {
            type : 'spline'
        },
        title : {
            text : 'Number of Best Sellers Sold'
        },
        subtitle : {
            text : ''
        },
        xAxis : {
            title : {
                text : 'Title of Book'
            },
            categories : name
        },
        yAxis : {
            allowDecimals: false,
            title : {
                text : 'Number Sold'
            },
            labels : {
                formatter : function() {
                    return this.value + ' Books'
                }
            }
        },
        tooltip : {
            crosshairs : true,
            shared : true,
            valueSuffix : ''
        },
        plotOptions : {
            spline : {
                marker : {
                    radius : 4,
                    lineColor : '#666666',
                    lineWidth : 1
                }
            }
        },
        series : [{

            name : 'Books Sold',
            data : numberSold
        }]
    });
    });
});