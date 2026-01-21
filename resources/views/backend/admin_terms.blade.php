@extends('frontend.components.layout')

@section('admin-terms')
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet"/>
    @endpush
    <div class="card card-style">
        <div class="content">
            <div class="tabs tabs-pill" id="tab-group-2">
                <div class="tab-controls rounded-m p-1">
                    @foreach($locales as $locale)
                        <a class="font-12 rounded-m" data-bs-toggle="collapse" href="#tab-{{$locale->abbr}}"
                           aria-expanded="{{$locale->main==1 ? 'true' : 'false'}}">{{$locale->language}}
                        </a>
                    @endforeach

                </div>
                <div class="mt-3"></div>
                <form action="{{route('admin.terms.store')}}" method="post"
                      id="terms_form">
                    @csrf
                    @foreach($locales as $locale)
                        <div class="collapse {{$locale->main==1 ? 'show' : ''}}" id="tab-{{$locale->abbr}}"
                             data-bs-parent="#tab-group-2" style="">
                            <div class="content">
                                <h1 class="font-20 line-height-m pb-2 text-center">
                                    Terms & Conditions ({{$locale->language}})
                                </h1>
                                <div class="divider mt-4"></div>
                                <input type="hidden" name="terms{{$locale->abbr}}" id="content_{{$locale->abbr}}">
                                <div id="editor{{$locale->abbr}}">
                                   {!! $terms?->getTranslation('text',$locale->abbr) !!}
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button
                                        class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                                        {{__('Update')}}
                                    </button>
                                </div>
                                <div class="divider mt-4"></div>
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
    <div class="card card-style over-card">

    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script>
            @foreach($locales as $locale)
                const quill{{$locale->abbr}} = new Quill('#editor{{$locale->abbr}}', {
                    theme: 'snow',
                    placeholder: 'Write description...',
                    bounds: document.body,
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ color: [] }, { background: [] }],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            [{ align: [] }],
                            ['blockquote', 'code-block'],
                            ['link', 'image', 'video'],
                            ['clean']
                        ],
                        history: {
                            delay: 2000,
                            maxStack: 500,
                            userOnly: true
                        },
                        clipboard: {
                            matchVisual: false
                        }
                    },
                    formats: [
                        'header', 'bold', 'italic', 'underline', 'strike',
                        'color', 'background',
                        'list', 'bullet', 'align',
                        'link', 'image', 'video',
                        'blockquote', 'code-block'
                    ]
                });
            @endforeach
            const form = document.getElementById('terms_form')

            form.addEventListener('submit', function (e) {
                e.preventDefault()
                @foreach($locales as $locale)
                    let html{{$locale->abbr}} = quill{{$locale->abbr}}.root.innerHTML;
                    document.getElementById('content_{{$locale->abbr}}').value = html{{$locale->abbr}}
                @endforeach
                form.submit()
            });

        </script>
    @endpush
@endsection
