@extends('frontend.components.layout')

@section('faqs')

    <div class="card card-style">
        <div class="content" >
            <div class="text-center pb-3">
                <h2 class="font-700">F.A.Q</h2>
            </div>
            <div class="accordion border-0 accordion-s" id="accordion-group-6">
                @foreach($faqs as $subject => $faqs2)
                    <h5>{{$subject}}</h5>
                    @foreach($faqs2 as $faq)
                        <div class="accordion-item">
                            <button class="accordion-button px-0 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion6-{{$faq->id}}"
                                    aria-expanded="false">
                                <span class="font-600 font-13">{{$faq->question}}</span>
                                <i class="bi bi-plus font-20"></i>
                            </button>
                            <div id="accordion6-{{$faq->id}}"
                                 class="accordion-collapse collapse" data-bs-parent="#accordion-group-6" style="">
                                <p class="pb-3 opacity-90">
                                    {{$faq->answer}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-style over-card">

    </div>

    @push('js')

    @endpush
@endsection
