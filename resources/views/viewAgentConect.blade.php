  <ul class="m-t-20 chatonline">
@foreach($usersConect as $userInfo)
<li>
    @if(!empty($userInfo->image))
    <a href="javascript:void(0)"><img src="{{ asset('assets/images/usuarios/' . $userInfo->image)}}" alt="user-img" class="img-circle"> 
      @else 
      <a href="javascript:void(0)"><img src="{{ asset('assets/images/usuarios/user.jpg')}}" alt="user-img" class="img-circle"> 
      @endif
      @if($userInfo->connected == 1)
        <span>{!!$userInfo->full_name !!} <small class="text-success">{!!$userInfo->connectedText!!}</small></span>
        @else
          <span>{!!$userInfo->full_name !!} <small class="text-black">{!!$userInfo->connectedText!!}</small></span>
        @endif
    </a>
</li>
@endforeach
</ul>