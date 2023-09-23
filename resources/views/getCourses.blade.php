<div class="text-right" style="padding: 10px;">
    <h4>Total: {!! $totalCourse !!}</h4>
</div>
<table class="table table-hover no-wrap" id="mas-vendidos">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Lugares</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courseMore as $courseMoreInfo)
        <tr>

            <td class="txt-oflo br-txt">{!! $courseMoreInfo->name !!}</td>
            <td><span class="text-success">{!! $courseMoreInfo->places !!}</span></td>

        </tr>
        @endforeach
    </tbody>
</table>
