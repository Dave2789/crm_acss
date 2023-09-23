 <option value="-1">Selecciona Mes</option>
@foreach($month as $monthInfo)
 <option value="{{ $monthInfo['pkMonth'] }}">{{ $monthInfo['nameMonth'] }}</option>
@endforeach