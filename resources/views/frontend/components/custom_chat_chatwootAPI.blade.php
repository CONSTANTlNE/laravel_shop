{{--<button id="chat-toggle" class="btn btn-primary rounded-circle shadow-lg position-fixed bottom-0 end-0 m-4" style="width: 60px; height: 60px; z-index: 1050;">--}}
{{--    <i class="bi bi-chat-dots-fill"></i>--}}
{{--</button>--}}


<div id="chat-widget" class="card shadow-lg d-none position-fixed overflow-hidden">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0">ონლაინ დახმარება</h6>
        <button type="button" class="btn-close btn-close-white" id="chat-close"></button>
    </div>

    <div class="card-body overflow-auto bg-light" id="chat-messages" style="height: 350px;">
        <div class="message-received mb-3">
            <div class="bg-white p-2 rounded shadow-sm d-inline-block border">
                გამარჯობა! რით შემიძლია დაგეხმაროთ?
            </div>
        </div>
    </div>

    <div class="card-footer bg-white border-top p-3">
        <form id="chat-form" class="input-group">
            <input type="text" id="chat-input" class="form-control" placeholder="ჩაწერეთ შეტყობინება..."
                   autocomplete="off">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-send"></i>
            </button>
        </form>
    </div>
</div>
