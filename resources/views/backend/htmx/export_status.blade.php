
<div hx-get="{{route('exports.message')}}"
     id="export_status"
     hx-trigger="load delay:2s"
     hx-swap="outerHTML">
    @if($export!=null)
        Ready
        <a href="{{ route('exports.download') }}" target="_blank">
            Download Export
        </a>
    @else
        Preparing download
    @endif
</div>
