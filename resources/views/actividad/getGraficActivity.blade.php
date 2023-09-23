<div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Actividades</h4>
                    <div>
                        <canvas id="typeActivities" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="title_subactivity">Llamadas</h4>
                    <div>
                        <canvas id="subtypeActivities" height="150"></canvas>
                    </div>
                  <!--  <a id="subActivityModal" data-id="0" href="#modalDetActividad" data-toggle="modal" data-target="#modalDetActividad"><span class="ti-eye"></span></a>-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h3 class="title-section">Actividades ejecutadas por agente </h3>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Todos los agentes</h4>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="totalActivitiesByAgent"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="title_agentActivities">Actividades de:  {{html_entity_decode($userHight)}}</h4>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="activitiesByAgent" data-id="{{$userHight}}"></div>
                    </div>
                   <!-- <a href="#modalDetAgente" data-toggle="modal" data-target="#modalDetAgente"><span class="ti-eye"></span></a>-->
                </div>
            </div>
        </div>
    </div>

<script>
    $(function () {
    
        new Chart(document.getElementById("typeActivities"),
        {
            "type":"pie",
            "data":{"labels":[<?php echo $namesTypeActivities; ?>],
                    "datasets":[{
                        "label":"Actividades",
                        "data":[<?php echo $totalTypeActivities; ?>],
                        "backgroundColor":[<?php echo $colorsTypeActivities; ?>]}
                    ]},
            options: {
                legend:{
                    onClick: function(event, item){
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            data: { "text": item.text},
                            url: '/loadPieGraphicTypeActivities',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                $("#title_subactivity").html(response.text);
                                $("#subActivityModal").data('id',response.text);
                                var obj = JSON.parse(response.data);
                                Char2.data = obj;
                                Char2.update();
                            }
                        });                        
                    }
                }
            }
        });
        
        var Char2 = new Chart(document.getElementById("subtypeActivities"),
        {
            "type":"pie",
            "data":{"labels":[<?php echo $namesSubtypeActivities; ?>],
            "datasets":[{
                "label":"Llamadas",
                "data":[<?php echo $totalSubtypeActivities; ?>],
                "backgroundColor":[<?php echo $colorsSubtypeActivities; ?>]}
            ]},
             options: {
                legend:{
                    onClick: function(event, item){
                        // console.log($("#title_subactivity").text()); 
                         var activity = $("#title_subactivity").text();
                         $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            data: { "text": item.text,"activity":activity },
                            url: '/loadModalSubActivity',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                $('#modalContDetActividad').empty();
                                $('#modalContDetActividad').html(response.view);
                                $('.modalDetActividad').trigger('click');
                            }
                        });   
                    }
                }
            }    
        });
            
    });
    
    
    $(function () {
    
        var data1 = [<?php echo $dataGraphicPie; ?>];

        var data2 = [<?php echo $dataGraphicPieTwo; ?>];
        
     


        $.plot($("#totalActivitiesByAgent"), data1, {
            series: {
                pie: {
                    innerRadius: 0.5
                    , show: true
                }
            }
            , grid: {
                hoverable: true,
                clickable: true
            }
            , color: null
            , tooltip: true
            , tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20
                    , y: 0
                }
                , defaultTheme: false
            }
        });
        
        $("#totalActivitiesByAgent").bind("plotclick", function(event, pos, obj) {
            if (!obj) { return;}
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: { "text": obj.series.label},
                url: '/loadPieGraphicAgents',
                beforeSend: function () {
                },
                success: function (response) {
                    $("#title_agentActivities").html("Actividades de: "+response.text);
                    $("#activitiesByAgent").data("id",response.text);
                    
                    var obj2 = JSON.parse(response.data);
                    plot.setData(obj2);
                    plot.setupGrid();
                    plot.draw();
                }
            });      
        });

        var plot =  $.plot($("#activitiesByAgent"), data2, {
            series: {
                pie: {
                    innerRadius: 0.5
                    , show: true
                }
            }
            , grid: {
                hoverable: true,
                clickable: true
            }
            , color: null
            , tooltip: true
            , tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20
                    , y: 0
                }
                , defaultTheme: false
            }
        });
        
        $("#activitiesByAgent").bind("plotclick", function(event, pos, obj) {
            if (!obj) { return;}
                 console.log( );
                 console.log(obj);
                 
               $.ajax({
                type: "POST",
                dataType: "JSON",
                data: { "text": obj.series.label
                       ,"user": $("#activitiesByAgent").data("id")},
                url: '/loadModalActivityByAgent',
                beforeSend: function () {
                },
                success: function (response) {
                   $('#modalContDetActividad').empty();
                                $('#modalContDetActividad').html(response.view);
                                $('.modalDetActividad').trigger('click');
                }
            });   
                 
        });
    });
</script>