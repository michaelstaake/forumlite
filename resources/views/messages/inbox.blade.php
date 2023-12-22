@php ($pageTitle = "Inbox")

@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/messages">Messages</a></li>
    <li class="breadcrumb-item active" aria-current="page">Inbox</li>
  </ol>
</nav>

<div class="page-title">
  Inbox
  <div class="float-sm-end"><a class="btn btn-primary" href="/message/new" role="button"><i class="bi bi-send"></i> New Message</a></div><br>
</div>

<div class="row">
	<div class="col-3">
    @include('messages.sidebar')
	</div>
	<div class="col-9">
    <div class="card messages-list">
      <div class="card-header">
        Inbox
      </div>
      <ul class="list-group list-group-flush">
        @foreach($messages as $m)
          <a href="/message/{{ $m->id }}" class="list-group-item list-group-item-action">
            @if ($m->status === "unread")
              <h6><strong>{{ $m->subject }}</strong> <i class="bi bi-envelope-fill"></i></h6>
            @else
              <h6>{{ $m->subject }} <i class="bi bi-envelope-open"></i></h6>
            @endif
            <p>{{ $m->content }}</p>
            <span>From: 
              @foreach ($m['user'] as $mu)
                {{ $mu->username }}
              @endforeach
            </span><span timestamp="{{ $m->created_at }}"></span>
          </a>
        @endforeach
      </ul>
    </div>
	</div>
</div>

@include('includes.footer')