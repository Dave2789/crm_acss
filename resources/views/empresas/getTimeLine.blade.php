<ul class="timeline">
    @php $cont = 0;  @endphp
    @foreach($arrayLineTime as $item)
    @if($cont%2==0)
    <li>
        @else
    <li class="timeline-inverted">    
        @endif         
        <div class="timeline-badge" style="background-color:{!!$item['color']!!}"><i class="{!!$item['icon']!!}"></i> </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">{!! $item["desc"]!!}</h4>
                <p><small class="text-muted"><i class="ti-calendar"></i> {!!$item["register_day"]!!} {!! $item["register_hour"]!!} </small><small class="pl-2 text-muted"><i class="ti-user"></i> {!!$item["full_name"] !!}</small> </p>
            </div>
            <div class="timeline-body">
                @if(!empty($item["document"]))
                                  <a href="/files/file/{{$item["document"]}}" download><i class="ti-download"></i> Descargar adjunto</a>
                                  @endif
            </div>
        </div>
    </li>
    @php $cont++;  @endphp
    @endforeach

</ul>

