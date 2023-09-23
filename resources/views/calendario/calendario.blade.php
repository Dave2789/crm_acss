<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.head')
    <link href="/assets/node_modules/calendar/dist/fullcalendar.css" rel="stylesheet" />
</head>

<body class="skin-default fixed-layout">
 
    <!-- Main wrapper - style you can find in pages.scss -->
    <div id="main-wrapper">
        @include('includes.header')
        <!-- End Topbar header -->

        @include('includes.sidebar')
        <!-- End Left Sidebar  -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Calendario</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Calendario</li>
                            </ol>
                              @if($arrayPermition["addActivity"] == 1)
                            <a href="#" id="createActivity" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Crear nueva actividad</a>
                             @endif
                        </div>
                    </div>
                </div>
           @if($arrayPermition["viewCalendar"] == 1)
                <!-- Calendario -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                             @if(Session::get("isAdmin") == 1)
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="slcAgentCalendary">Agente:</label>
                                    <select id="slcAgentCalendary" class="custom-select form-control input-sm m-b-10">
                                        <option value="-1">Selecciona un agente</option>
                                        @foreach($agentes as $infoAgent)
                                        @if($infoAgent->pkUser == $agent)
                                        <option selected value="{{ $infoAgent->pkUser }}">{!! $infoAgent->full_name !!}</option>
                                        @else
                                        <option  value="{{ $infoAgent->pkUser }}">{!! $infoAgent->full_name !!}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             @endif
                            <div class="col-lg-12">
                                <div class="b-l calender-sidebar">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->
 <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">
       
      </div>
    </div>
      @if($arrayPermition["addActivity"] == 1) 
        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario2" class="modalEditUsuario2"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditUsuario2" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario2" role="document">
       
      </div>
    </div>
       @endif
        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->

    @include('includes.scripts')
    <!-- End scripts  -->
    <!-- Calendar JavaScript -->
    <script src="/assets/node_modules/calendar/jquery-ui.min.js"></script>
    <script src="/assets/node_modules/moment/moment.js"></script>
    <script src='/assets/node_modules/calendar/dist/fullcalendar.min.js'></script>
    <script src='/assets/node_modules/calendar/dist/locale/es.js'></script>
    
    <script>
   $(document).ready(function(){     
          console.log($('#slcAgentCalendary').val());
        var defaultEvents = [];
        var agent = $('#slcAgentCalendary').val();
        
           $.ajax({
                type: "POST",
                dataType: "json",
                data: {"agent" : agent},
                url: '/getDaysActivity',
                beforeSend: function () {
                },
                success: function (response) {
                   
              defaultEvents = response.event;

         console.log(defaultEvents);
!function($) {
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$categoryForm = $('#add-new-event form'),
        this.$extEvents = $('#calendar-events'),
        this.$modal = $('#my-event'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$calendarObj = null
    };


    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) { 

    },
    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
         
        var pkActivity  = calEvent["id"];     
     
        
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {"pkActivity": pkActivity},
                url: '/getDetailActivity',
                beforeSend: function () {
                },
                success: function (response) {
                    if(response.valid == "true"){
                       
                        $('#modalUsuario').empty();
                        $('#modalUsuario').html(response.view);
                         $('#optionQuotation').hide();
                        $('.modalEditUsuario').trigger('click');
                        
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al editar'
                        });
                    }
                }
            });
    },
    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
       
    },
    CalendarApp.prototype.enableDrag = function() {
       
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());


        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '19:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,   
             
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: defaultEvents,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

        });

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="calendar-events" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + '"></i>' + categoryName + '</div>')
                $this.enableDrag();
            }

        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);
                }
            });
            

 
});
        </script>
</body>


</html>