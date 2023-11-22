@foreach($member as $m) @php ($pageTitle = $m->username)  @endforeach
@include('includes.header')

<div class="page-title">
    {{ $m->username }}
    @if ($m->username != auth()->user()->username)
        <div class="float-sm-end"><a class="btn btn-primary" href="/message/new/{{ $m->username }}" role="button"><i class="bi bi-send"></i> Message User</a></div><br>
    @endif
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
                        @foreach ($m['discussions'] as $d)
                            <li class="list-group-item">
                                <h6><a href="/discussion/{{ $d->slug }}">{{ $d->title }}</a></h6>
                                <p>{!! $d->content !!}</p>
                                <span>{{ $d->datetime }}</span>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card member-activity-card">
                    <div class="card-header">
                        Comments ({{ $m->numComments }})
                    </div>
                    <ul class="list-group list-group-flush">
                         @foreach ($m['comments'] as $c)
                            <li class="list-group-item">
                                @foreach ($c['discussion'] as $cd)
                                <h6>in <a href="/discussion/{{ $cd->slug }}#comment-{{ $c->id }}">{{ $cd->title }}</a></h6>
                                @endforeach
                                <p>{!! $c->content !!}</p>
                                <span>{{ $c->datetime }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <img class="member-avatar" src="{{asset('storage/avatars/' . $m->avatar)}}" />
        <ul class="member-stats">
            <li>Joined: {{ $m->dateTimeCreated }}</li>
            <li>Last Active: {{ $m->dateTimeActive }}</li>
            <li>Location: {{ $m->location }}</li>
            <li><a href="#">Report User</a></li>
        </ul>
    </div>
</div>

@include('includes.footer')