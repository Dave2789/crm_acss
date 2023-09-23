<ul>
    <li>
        <div class="drop-title">Notificaciones</div>
    </li>
    <li>
        <div class="message-center">
            <!-- Message -->
         @if(sizeof($notification) > 0)
           @foreach($notification as $notificationInfo)
           <a class="viewNotification" data-document="{!!$notificationInfo->document !!}" href="javascript:void(0)" data-quotation="{!!$notificationInfo->fkQuotation !!}" data-type="{!!$notificationInfo->type !!}" data-id="{!!$notificationInfo->pkUser_per_alert!!}" data-title="{!!$notificationInfo->title!!}" data-comment="{!!$notificationInfo->comment!!}">
                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                <div class="mail-contnet">
                    <h5>{!!$notificationInfo->title !!}</h5> <span class="mail-desc">{!!$notificationInfo->comment !!}</span> <!--<span class="time">9:30 AM</span>--> </div>
            </a>
           @endforeach
           @else
           <a href="javascript:void(0)">
               Sin Notificaciones
           </a>
           @endif
        </div>
    </li>
    <li>
       <!-- <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Ver todas las notificaciones</strong> <i class="fa fa-angle-right"></i> </a>-->
    </li>
</ul>