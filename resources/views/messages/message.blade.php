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
          <span>{{ $m->datetime }}</span>
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
  <btn class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportMessageModal"><i class="bi bi-exclamation-triangle"></i> Report</btn>
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

<!-- #reportMessageModal -->
<div class="modal modal-lg fade" id="reportMessageModal" tabindex="-1" aria-labelledby="reportMessageLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('report.message') }}" class="">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="reportMessageLabel">Report Message</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="id_of_reported" value="{{ $m->id }}" />
            <input type="hidden" name="who_reported" value="{{ auth()->user()->username }}" />
            <p>Report reason:</p>
            <textarea class="form-control" name="reason" rows="3" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@include('includes.footer')