<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Desglose de cotización</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            @php $cont = 1; @endphp
            @foreach($quotationDetail as $quotationDetailInfo)
            <div class="col-md-12">
                <h4>Opción # {{$cont}} {{ $quotationDetailInfo->type }}</h4>
                 <h6>Lugares # {{$quotationDetailInfo->number_places}}</h6>
           
             
               @foreach($cursesArray[$quotationDetailInfo->pkQuotations_detail] as $infoCourse)
           <div class="coursesQuotation"> 
           <div class="col-md-12">
            <div class="row pt-3">   
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Curso *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" id="fkCourse" class="form-control fkCourse" data-id="{{$infoCourse->pk_quotation_by_courses}}" value="{!! $infoCourse->name !!}">
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Lugares *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                        </div>
                        <input type="text" id="places" class="form-control places">
                    </div>
                </div>
            </div>
           </div>
           </div>
           </div>
               @endforeach
    </div>
             @php $cont++; @endphp
            @endforeach

            <div class="col-md-12 text-right">
                <button class="btn btn-success btn-generatedb" data-id="{{$pkQuotations }}" ><span class="ti-check"></span> Generar desglose</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
