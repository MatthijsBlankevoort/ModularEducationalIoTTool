var chart = c3.generate({
    data: {
        x: 'x',
        columns: [
            ['x', '2012-12-28', '2012-12-29', '2012-12-30', '2012-12-31'],
            ['test', 20.8, 23.0,  21.3, 22.2],
        ]
    },
    axis: {
        x: {
            type: 'timeseries',
            tick: {
                format: '%m/%d',
            }
        }
    },


});

var date = new Date ("2013-01-01");
setInterval(function () {
    chart.flow({
        columns: [
            ['x', new Date (date)],
            ['test', 20 + (Math.random() * 5)],
        ],
        duration: 750,
    });
    date.setDate(date.getDate() + 1);
}, 2000);

