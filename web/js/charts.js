Highcharts.createElement('link', {
   href: 'https://fonts.googleapis.com/css?family=Unica+One',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee", '#FFA500'],
   chart: {
      backgroundColor: '#2a2a2b',
      style: {
         fontFamily: "sans-serif",
         fontSize: '13px'
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3',
         fontWeight: 'normal',
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      },
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

Highcharts.setOptions(Highcharts.theme);

Highcharts.setOptions({
    global: {
        useUTC: false
    },
    lang: {
        loading: 'Загрузка...',
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        weekdays: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        shortMonths: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
        exportButtonTitle: "Экспорт",
        printButtonTitle: "Печать",
        rangeSelectorFrom: "С",
        rangeSelectorTo: "По",
        rangeSelectorZoom: "Период",
        downloadPNG: 'Скачать PNG',
        downloadJPEG: 'Скачать JPEG',
        downloadPDF: 'Скачать PDF',
        downloadSVG: 'Скачать SVG',
        printChart: 'Напечатать график'
    },
    plotOptions: {
        column: {
            pointPadding: 0,
            borderWidth: 0,
            groupPadding: 0,
            shadow: false
        }
    }
});

function create_chart(data) {
    $('#container1').highcharts({
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: [{
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%e %b, %Y',
                year: '%b'
            },
            tickInterval: 3600 * 1000 * 2,
        }],
        yAxis: [{
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[2]
                }
            },
            title: {
                text: 'Температура',
                style: {
                    color: Highcharts.getOptions().colors[2]
                }
            },
            opposite: false,

        }, {
            gridLineWidth: 0,
            title: {
                text: 'Влажность',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} %',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true,
            min: 0,
            max: 100,

        }],
        tooltip: {
            shared: true,
            xDateFormat: '%A, %d %B %Y, %H:%M'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 60,
            verticalAlign: 'top',
            y: 8,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Влажность',
            type: 'area',
            yAxis: 1,
            data: data.humd,
            tooltip: {
                valueSuffix: ' %'
            }

        }, {
            name: 'На улице',
            type: 'spline',
            data: data.temp1,
            color: Highcharts.getOptions().colors[2],
            tooltip: {
                valueSuffix: ' °C'
            }
        }, {
            name: 'В помещении',
            type: 'spline',
            data: data.temp2,
            color: Highcharts.getOptions().colors[5],
            tooltip: {
                valueSuffix: ' °C'
            }
        }]
    });

    $('#container2').highcharts({
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: [{
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%e %b, %Y',
                year: '%b'
            },
            tickInterval: 3600 * 1000 * 2,
        }],
        yAxis: [{
            labels: {
                style: {
                    color: Highcharts.getOptions().colors[11]
                }
            },
            title: {
                text: 'Освещенность (lux)',
                style: {
                    color: Highcharts.getOptions().colors[11]
                }
            },
            opposite: false,

        }, {
            gridLineWidth: 0,
            title: {
                text: 'Скорость ветра (м/с)',
                style: {
                    color: Highcharts.getOptions().colors[9]
                }
            },
            labels: {
                style: {
                    color: Highcharts.getOptions().colors[9]
                }
            },
            opposite: true,
        }, {
            gridLineWidth: 0,
            title: {
                text: 'Атмосферное давление (мм.рт.ст.)',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true,
        }],
        tooltip: {
            shared: true,
            xDateFormat: '%A, %d %B %Y, %H:%M'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 60,
            verticalAlign: 'top',
            y: 8,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Освещенность',
            type: 'area',
            yAxis: 0,
            data: data.light,
            color: Highcharts.getOptions().colors[11],
            tooltip: {
                valueSuffix: ' lux'
            }
        }, {
            name: 'Скорость ветра',
            type: 'column',
            yAxis: 1,
            data: data.wind,
            pointWidth: $("a[data-period='month']").hasClass('active') ? 15 : 2,
            color: '#7898BF',
            marker: {
                enabled: false
            },
            tooltip: {
                valueSuffix: ' м/с'
            }

        }, {
            name: 'Атмосферное давление',
            type: 'spline',
            yAxis: 2,
            data: data.press,
            color: Highcharts.getOptions().colors[1],
            marker: {
                enabled: false
            },
            tooltip: {
                valueSuffix: ' мм.рт.ст.'
            }

        }]
    });

    $('#container3').highcharts({
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%e %b, %Y',
                year: '%b'
            },
            tickInterval: 3600 * 1000 * 2,
        },
        yAxis: {
            labels: {
                style: {
                    color: Highcharts.getOptions().colors[7]
                }
            },
            title: {
                text: 'Напряжение (В)',
                style: {
                    color: Highcharts.getOptions().colors[7]
                }
            },
            min: data.min_v,
            max: data.max_v
        },
        tooltip: {
            shared: true,
            xDateFormat: '%A, %d %B %Y, %H:%M'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 60,
            verticalAlign: 'top',
            y: 8,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Напряжение АКБ',
            type: 'area',
            yAxis: 0,
            data: data.battery,
            color: Highcharts.getOptions().colors[7],
            tooltip: {
                valueSuffix: ' v'
            }
        }]
    });
}

function show_loading() {
    $('#container1').html('<div class="loading"></div>');
    $('#container2').html('<div class="loading"></div>');
    $('#container3').html('<div class="loading"></div>');
}

$(function () {
    $.getJSON(dir_root + 'statistics?data=true', function (data) {
        create_chart(data);
    });

    $("a[data-role='period']").click(function() {
        show_loading();

        $("a[data-role='period']").removeClass('active');
        $(this).addClass('active');

        var period = $(this).attr("data-period");

        $.getJSON(dir_root + 'statistics?data=true&period=' + period, function (data) {
            create_chart(data);
        });
    });
});