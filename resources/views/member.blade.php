@foreach($member as $m) @php ($pageTitle = $m->username)  @endforeach
@include('includes.header')

<div class="page-title">
    {{ $m->username }}
    @auth
        @if ($m->username != auth()->user()->username)
            <div class="float-sm-end"><a class="btn btn-primary" href="/message/new/{{ $m->username }}" role="button"><i class="bi bi-send"></i> Message User</a></div><br>
        @endif
    @endauth
</div>
<div class="row">
    <div class="col-9">
        <div class="row">
            <div class="col">
                <div class="card member-activity-card">
                    <div class="card-header">
                        Discussions ({{ $m->numDiscussions }})
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($m['discussions'] as $d)
                            @if($loop->index < 5)
                                <li class="list-group-item">
                                    <h6><a href="/discussion/{{ $d->slug }}">{{ $d->title }}</a></h6>
                                    <p>{{ $d->content }}</p>
                                    <span timestamp="{{ $d->created_at }}"></span>
                                </li>
                            @endif
                        @empty
                            No discussions.
                        @endforelse
                        
                    </ul>
                    @if ($m->numDiscussions > 0)
                        <div class="card-footer">
                            <a href="/search/discussions/{{ $m->username }}">View all discussions</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="card member-activity-card">
                    <div class="card-header">
                        Comments ({{ $m->numComments }})
                    </div>
                    <ul class="list-group list-group-flush">
                         @forelse ($m['comments'] as $c)
                            @if($loop->index < 5)
                                <li class="list-group-item">
                                    @foreach ($c['discussion'] as $cd)
                                    <h6>in <a href="/discussion/{{ $cd->slug }}#comment-{{ $c->id }}">{{ $cd->title }}</a></h6>
                                    @endforeach
                                    <p>{{ $c->content }}</p>
                                    <span timestamp="{{ $c->created_at }}"></span>
                                </li>
                            @endif
                        @empty
                            No discussions.
                        @endforelse
                    </ul>
                    @if ($m->numComments > 0)
                        <div class="card-footer">
                            <a href="/search/comments/{{ $m->username }}">View all comments</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <img class="member-avatar" src="{{asset('storage/avatars/' . $m->avatar)}}" />
        <ul class="member-stats">
            <li timestamp="{{ $m->created_at }}">Joined: </li>
            <li timestamp="{{ $m->last_active }}">Last Active: </li>
            <li>Location: {{ $m->location }}</li>
            @auth
                @if ($m->username != auth()->user()->username)
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#reportUserModal">Report User</a></li>
                @endif
            @endauth
        </ul>
    </div>
</div>

@auth
<!-- #reportUserModal -->
<div class="modal modal-lg fade" id="reportUserModal" tabindex="-1" aria-labelledby="reportUserLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('report.user') }}" class="">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="reportUserLabel">Report {{ $m->username }}</h1>
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
@endauth

@include('includes.footer')