@extends('frontend.components.layout')

@section('admin-faqs')
    <div class="card card-style">
        <div class="content">
            <div class="tabs tabs-pill" id="tab-group-2">
                <div class="tab-controls rounded-m p-1">
                    @foreach($locales as $locale)
                        <a class="font-12 rounded-m" data-bs-toggle="collapse" href="#faq-{{$locale->abbr}}"
                           aria-expanded="{{$locale->main==1 ? 'true' : 'false'}}">{{$locale->language}}
                        </a>
                    @endforeach
                </div>
                <div class="mt-3"></div>
                <form class="content" action="{{route('faqs.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <p class="font-24 font-800 mb-3 text-center">Add FAQ</p>
                    @foreach($locales as $locale)
                        <div data-bs-parent="#tab-group-2" class="collapse {{$locale->main==1 ? 'show' : ''}}"
                             id="faq-{{$locale->abbr}}">
                            <div class="form-custom mb-3 form-floating">
                                <input type="text" name="subject_{{$locale->abbr}}"
                                       class="form-control rounded-xs"
                                       id="c1111{{$locale->abbr}}"
                                       value="{{old('subject_'.$locale->abbr)}}"
                                       placeholder="Subject"/>
                                <label for="c1111{{$locale->abbr}}"
                                       class="color-theme">Subject {{$locale->language}} </label>
                                <span>(Optional)</span>
                            </div>
                            <div class="form-custom mb-3 form-floating">
                                <input type="text" name="question_{{$locale->abbr}}"
                                       class="form-control rounded-xs"
                                       id="c1{{$locale->abbr}}"
                                       @required($locale->main==1)
                                       value="{{old('question_'.$locale->abbr)}}"
                                       placeholder="Question"/>
                                <label for="c1{{$locale->abbr}}"
                                       class="color-theme">Question {{$locale->language}} </label>
                                @if($locale->main==1)
                                    <span>(required)</span>
                                @endif
                            </div>
                            <div class="form-custom mb-3 form-floating">
                                <i class="bi bi-pencil-fill font-12 disabled"></i>
                                <textarea class="form-control rounded-xs"
                                          placeholder="Leave a comment here"
                                          name="answer_{{$locale->abbr}}"
                                          @required($locale->main==1)
                                          id="c7{{$locale->abbr}}">{{old('answer_'.$locale->abbr)}}</textarea>
                                <label for="c7{{$locale->abbr}}"
                                       class="color-theme">Answer {{$locale->language}}</label>
                                @if($locale->main==1)
                                    <span>(required)</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        <button
                            class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="divider"></div>
    <br>

    <div class="card card-style over-card">
        <div class="content">
            <p class="font-24 font-800 mb-3 text-center">Update FAQ</p>
            @foreach($faqs as $subject => $faqs2)
                <h5 class="text-center">{{$subject}}</h5>
                @foreach($faqs2 as $faq)
                    <div class="tabs tabs-pill mt-3" id="tab-group-{{$faq->id}}">
                        <div class="tab-controls rounded-m p-1">
                            @foreach($locales as $locale)
                                <a class="font-12 rounded-m" data-bs-toggle="collapse"
                                   href="#update_faq-{{$locale->abbr}}{{$faq->id}}"
                                   aria-expanded="{{$locale->main==1 ? 'true' : 'false'}}">{{$locale->language}}
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3"></div>
                        <form class="content" action="{{route('faqs.update')}}" method="post"
                              id="update{{$faq->id}}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="faq_id" value="{{$faq->id}}">
                            @foreach($locales as $locale)
                                <div data-bs-parent="#tab-group-{{$faq->id}}"
                                     class="collapse {{$locale->main==1 ? 'show' : ''}}"
                                     id="update_faq-{{$locale->abbr}}{{$faq->id}}">
                                    <div class="form-custom mb-3 form-floating">
                                        <input type="text" name="subject_{{$locale->abbr}}"
                                               class="form-control rounded-xs"
                                               id="c1111{{$locale->abbr}}"
                                               value="{{$faq->getTranslation('subject',$locale->abbr)}}"
                                               placeholder="Subject"/>
                                        <label for="c1111{{$locale->abbr}}"
                                               class="color-theme">Subject {{$locale->language}} </label>
                                        <span>(Optional)</span>
                                    </div>
                                    <div class="form-custom mb-3 form-floating">
                                        <input type="text" name="question_{{$locale->abbr}}"
                                               class="form-control rounded-xs"
                                               id="c1{{$locale->abbr}}"
                                               @required($locale->main==1)
                                               value="{{$faq->getTranslation('question',$locale->abbr)}}"
                                               placeholder="Question"/>
                                        <label for="c1{{$locale->abbr}}"
                                               class="color-theme">Question {{$locale->language}} </label>
                                        @if($locale->main==1)
                                            <span>(required)</span>
                                        @endif
                                    </div>
                                    <div class="form-custom mb-3 form-floating">
                                        <i class="bi bi-pencil-fill font-12 disabled"></i>
                                        <textarea class="form-control rounded-xs"
                                                  placeholder="Leave a comment here"
                                                  name="answer_{{$locale->abbr}}"
                                                  @required($locale->main==1)
                                                  id="c7{{$locale->abbr}}">{{$faq->getTranslation('answer',$locale->abbr)}}</textarea>
                                        <label for="c7{{$locale->abbr}}"
                                               class="color-theme">Answer {{$locale->language}}</label>
                                        @if($locale->main==1)
                                            <span>(required)</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </form>
                            <div class="d-flex justify-content-center gap-2">
                                <button form="update{{$faq->id}}"
                                    class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                                    Update
                                </button>
                                <form action="{{route('faqs.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="faq_id" value="{{$faq->id}}">
                                    <button
                                        class="default-link btn btn-m rounded-s gradient-red shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                                        Delete
                                    </button>
                                </form>
                            </div>

                    </div>
                    <br>
                    <div class="divider"></div>
                    <br>
                @endforeach
            @endforeach
        </div>
    </div>

    @push('js')

    @endpush
@endsection
