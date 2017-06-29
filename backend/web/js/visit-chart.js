//初始化图表
var myChart = echarts.init(document.getElementById('chart'));

//默认pv
getVisit({mode: 'pv'});

//自定义时间
$("#search").click(function(){
    var value = $("input[name=time_range]").val();

    if (value.length>0) {
        $(".show-more-div button").removeClass("active");
        var modeId = $("#visit ul").find('.active a').attr('id');
        var mode = modeId=='page-views-chart' ? 'pv': 'uv';
        var data = {mode: mode, date_type: 'search', date: value};

        getVisit(data);
    }    
});

//uv，pv切换
$("#visit ul").find('li a').click(function(){
    var value = $("input[name=time_range]").val();
    var modeId = $(this).attr('id');

    if (value.length>0) {
        var mode = modeId=='page-views-chart' ? 'pv': 'uv';
        var data = {mode: mode, date_type: 'search', date: value};

        getVisit(data);
    }else{
        var buttonId = $(".show-more-div").find('.active').attr('id');

        selectType(modeId, buttonId);
    }
});

//时间类型快捷选择
$(".show-more-div button").click(function(){
    $("input[name=time_range]").val('');
    $(".show-more-div button").removeClass("active");
    $(this).addClass("active");
    var buttonId = $(this).attr("id");
    var modeId = $("#visit ul").find('.active a').attr('id');

    selectType(modeId, buttonId);
});

//判断请求数据的类型
function selectType(modeId, buttonId){

    var mode = modeId=='page-views-chart' ? 'pv': 'uv';

    switch (buttonId)
    {
        case 'a_week': 
            var date_type = 'a_week';
            break;

        case 'three_week': 
            var date_type = 'three_week'; 
            break;

        case 'one_month': 
            var date_type = 'one_month'; 
            break;

        case 'three_month': 
            var date_type = 'three_month'; 
            break;

        case 'half_year': 
            var date_type = 'half_year'; 
            break;

        case 'one_year': 
            var date_type = 'one_year'; 
            break;

        default:
            break;
    }

    var data = {mode: mode, date_type: date_type};

    getVisit(data);
}

//获取图表数据
function getVisit(data){
    myChart.showLoading({text: "图表数据正在努力加载..."});
    $.ajax({
        url: 'http://admin.0xkerwin.com/site/visit',
        type: 'GET',
        dataType: 'json',
        data: data,
        success: function(res){
            // console.log(res);
            getChart(res.date, res.visit, '近一周');
        },
        error: function(res){
            alert('网络异常，请稍后重试！');
        }
    });
}

//呈现图表
function getChart(xData, yData, title){

    option = {
        /*title : {
            text: title,
            textStyle: {
                fontWeight: 'bolder',
                fontSize: '15',
            },
        },*/
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['访问人数'],
        },
        grid: {
            top: '20%',
        },
        toolbox: {
            show : true,
            feature : {
                magicType : {show: true, type: ['line', 'bar']},
                saveAsImage : {show: true},
                restore: {show: true}
            },
        },
        dataZoom: {
            type: 'inside'
        },
        calculable : true,
        xAxis : [
            {
            type : 'category',
            name : '日期',
            axisLabel: {
                rotate: 40
            },
            data : xData
            }
        ],
        yAxis : [
            {
                type: 'value',
                name: '人数',
                // interval: 10,
                axisLabel: {
                    // formatter: '{value}%'
                },                
            }
        ],
        series : [
        {
            name:'访问人数',
            type:'line',
            data:yData,
            itemStyle:{
                normal:{
                    color: '#43a3e4'
                }
            }
        }

        ]
    };
    
    myChart.setOption(option);
    myChart.hideLoading();
}