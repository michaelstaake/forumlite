@foreach($message as $m) @php ($pageTitle = $m->subject) @endforeach

@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/messages">Messages</a></li>
    @if ($m->folder === "inbox")
      <li class="breadcrumb-item"><a href="/messages/inbox">Inbox</a></li>
    @else
      <li class="breadcrumb-item"><a href="/messages/sent">Sent</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">{{ $m->subject }}</li>
  </ol>
</nav>

<div class="page-title">
  {{ $m->subject }}
</div>

<div class="card">
  <ul class="messages-message">
    <li class="">
      <div class="messages-message-member">
        @foreach ($m['user'] as $u)
        <div class="messages-message-member-avatar">
          <a href="/member/{{ $u->username }}"><img src="{{asset('storage/avatars/' . $u->avatar)}}" /></a>
        </div>
        <div class="messages-message-member-meta">
          <h6><a href="/member/{{ $u->username }}">{{ $u->username }}</a></h6>
          <span>{{ $m->created_at }}</span>
        </div>
        @endforeach
      </div>
      <div class="clearfix"></div>
      <div class="messages-message-content">
        <p>{{ $m->content }}</p>
      </div>
    </li>
  </ul>
</div>

@if ($m->folder === "inbox")
  <div class="float-sm-end message-buttons">
  <a class="btn btn-primary" href="/message/new/{{ $u->username }}" role="button"><i class="bi bi-reply"></i> Reply</a>
  <a class="btn btn-danger" href="#" role="button"><i class="bi bi-exclamation-triangle"></i> Report</a>
</div>
@else
  <p>Sent to: 
    @foreach ($m['recipient'] as $r)
      <a href="/member/{{ $r->username }}">{{ $r->username }}</a> 
    @endforeach
  </p>
@endif

<br>
<br>
<br>

@include('includes.footer')