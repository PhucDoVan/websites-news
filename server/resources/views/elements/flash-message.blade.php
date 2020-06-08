@if(session('error_message'))
    <div id="error_message">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">
                ×
            </span>
            </button>
            <p>
                {{ Session::get('error_message') }}
            </p>
        </div>
    </div>
    @php
        Session::forget('error_message');
    @endphp
@endif

@if(session('success_message'))
    <div id="success_message">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">
                ×
            </span>
            </button>
            <p class="msg_body">
                {{ Session::get('success_message') }}
            </p>
        </div>
    </div>
    @php
        Session::forget('success_message');
    @endphp
@endif
