function drawStatusPieChart(id, title, statuses, data, callback)
{
    var titleTextStyle = {
        color:'#fff',
        fontSize: 14
    };
    var tooltip = {
        trigger: 'item',
        formatter: '{a} <br/>{b}: {c} ({d}%)'
    };
    var legendLeft = '0';
    var legendTop  = '25';
    var legendItemWidth = 10;
    var legendItemHeight = 10;
    var legendTextStyle = {
        color:'#fff',
        fontSize: 12
    };
    var seriesTop = '50';
    var seriesRadius = ['40%', '70%'];
    var seriesLabel = {
        color:'#fff',
        formatter: '{b}  {d}%'
    };

    var chart  = echarts.init(document.getElementById(id));
    var option = {
	    title: {
            text: title,
            textStyle: titleTextStyle,
        },
        tooltip: tooltip,
        legend: {
            left: legendLeft,
            top: legendTop,
            itemWidth: legendItemWidth,
            itemHeight: legendItemHeight,
            textStyle: legendTextStyle,
            data: statuses
        },
        series: [
            {
                name: title,
                type: 'pie',
                top: seriesTop,
                radius: seriesRadius,
                avoidLabelOverlap: false,
                label: seriesLabel,
                data: data
            }
        ]
    }
    chart.setOption(option);
    if(typeof(callback) == 'function') chart.on('finished', callback);
    
    return chart;
}

function drawMonthsBarChart(id, title, legends, xAxis, data)
{
    var titleTextStyle = {
        color:'#fff',
        fontSize: 14
    };
    var tooltip = {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
    };
    var legendLeft = 'center';
    var legendTop  = '0';
    var legendItemWidth = 10;
    var legendItemHeight = 10;
    var legendTextStyle = {
        color:'#fff',
        fontSize: 12
    };
    var labelStyle = {color:'#fff'}

    var chart  = echarts.init(document.getElementById(id));
    var option = {
	    title: {
            text: title,
            textStyle: titleTextStyle,
        },
        tooltip: tooltip,
        legend: {
            left: legendLeft,
            top: legendTop,
            itemWidth: legendItemWidth,
            itemHeight: legendItemHeight,
            textStyle: legendTextStyle,
            data: legends
        },
        grid: {
          left: '0%',
          right: '0%',
          bottom: '2%',
          containLabel: true
        },
        yAxis: {
          type: 'value',
          axisLine: {show: true },
          splitLine: {show: false},
          axisLabel: labelStyle
        },
        xAxis: {
          type: 'category',
          axisLabel: labelStyle,
          axisTick: {alignWithLabel: true},
          data: xAxis
        },
        series: data
    }
    chart.setOption(option);
    
    return chart;
}

/**
 * Export annual data to image file
 * @param {function} sucessCallback
 * @param {function} errorCallback
 * @return {void}
 */
function exportAnnualImage(sucessCallback, errorCallback)
{
    var $main = $('#main');
    if($main.hasClass('exporting')) return;
    var $loading = $('#loadIndicator');
    $loading.addClass('loading');
    var $container = $('#container');
    $main.addClass('exporting').css('background-color', $container.css('background-color'));
    var afterFinish = function(canvas)
    {
        $main.removeClass('exporting');
        $loading.removeClass('loading');
    };
    html2canvas($main[0], {logging: false}).then(function(canvas)
    {
        canvas.onerror = function()
        {
            afterFinish(canvas);
            if(errorCallback) errorCallback('Cannot convert image to blob.');
        };
        canvas.toBlob(function(blob)
        {
            var imageUrl = URL.createObjectURL(blob);
            $('#imageDownloadBtn').attr({href: imageUrl})[0].click();
            if(sucessCallback) sucessCallback(imageUrl);
            afterFinish(canvas);
        });
    });
}

$(function()
{
    $('#exportBtn').on('click', function()
    {
        exportAnnualImage();
    });

    $('select#year, select#dept, select#userID').change(function()
    {
        var dept   = $('select#dept').val();
        var userID = $('select#userID').val();
        if($(this).attr('id') == 'dept') userID = 0;
        location.href = createLink('report', 'annualData', 'year=' + $('select#year').val() + '&dept=' + dept + '&userID=' + userID);
    });

    $('#actionData > div > ul > li').mouseenter(function(e)
      {
        $('#actionData > div > ul > li .dropdown-menu').css('left', e.pageX - $(this).offset().left + 10);
      })
});
