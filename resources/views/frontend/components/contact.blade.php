<div class="text-center d-flex flex-wrap justify-content-center align-middle gap-3">
    @foreach($socials as $social)
        @php

            $svg = $social->icon; // SVG stored in the database
            $newWidth =  $social->width;
            $newHeight = $social->height;

        $svg = preg_replace('/width="\d+(\.\d+)?(px)?"/i', 'width="'.$newWidth.'"', $svg);
        $svg = preg_replace('/height="\d+(\.\d+)?(px)?"/i', 'height="'.$newHeight.'"', $svg);

        @endphp

        @if($social->name==='whatsapp')
            <a rel="nofollow" target="_blank" href="https://wa.me/{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif

        @if($social->name==='telegram')
            <a rel="nofollow" target="_blank" href="https://t.me/{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif

        @if($social->name==='tiktok')
            <a rel="nofollow" target="_blank" href="{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif

        @if($social->name==='instagram')
            <a rel="nofollow" target="_blank" href="{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif
        @if($social->name==='facebook')
            <a rel="nofollow" target="_blank" href="{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif

        @if($social->name==='mobile')
            <a rel="nofollow" target="_blank" href="tel:{{$social->url}}">
                {!! $svg !!}
            </a>
        @endif

    @endforeach

</div>

