<div class="search-container">
    <div class="search-container-products">
        <div class="search-container-title">
            Empresas
        </div>
        <div class="search-container-content-products">
            @foreach($bussiness as $item)
            <div class="search-item" data-type="product" data-id="{!!$item->pkBusiness!!}">{!!$item->name!!}</div>
            @endforeach
        </div>
    </div>

</div>