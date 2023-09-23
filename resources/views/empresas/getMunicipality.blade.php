<option value="-1">Selecciona un municipio</option>
@foreach($municipality as $item)
<option value="{!!$item->cve_mun!!}">{!!$item->nom_mun!!}</option>
@endforeach