@foreach($discussions as $d) @php ($pageTitle = $d->title)  @endforeach

@include('includes.header')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/index">Home</a></li>
    @foreach ($d['section'] as $ds)
    	<li class="breadcrumb-item"><a href="/#{{ $ds->slug }}">{{ $ds->name }}</a></li>
    @endforeach
    @foreach ($d['category'] as $dc)
    	<li class="breadcrumb-item"><a href="/category/{{ $dc->slug }}">{{ $dc->name }}</a></li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">Discussion</li>
  </ol>
</nav>

<div class="page-title">
	 {{ $d->title }}
	 @if ($d->is_locked == TRUE)
	 	<span class="badge bg-secondary">Closed</span>
	 @endif
	 @if ($d->is_hidden == TRUE)
	 	<span class="badge bg-secondary">Hidden</span>
	 @endif
	 @auth
	 	@if ($d->can_watch == "TRUE")
        <div class="float-sm-end"><a class="btn btn-secondary" href="/watch/{{ $d->slug }}" role="button"><i class="bi bi-eye"></i> Watch Discussion</a></div><br>
		@endif
    @endauth
</div>


		<ul class="forum-discussion-replies">
			<li class="forum-discussion-reply" id="comment-0">
			@foreach ($d['user'] as $u)
				<div class="reply-member">
					<div class="reply-member-avatar">
						<a href="/member/{{ $u->username }}"><img src="{{asset('storage/avatars/' . $u->avatar)}}" /></a>
					</div>
					<div class="reply-member-meta">
						<h6><a href="/member/{{ $u->username }}" id="comment-0-username">{{ $u->username }}</a></h6>
			@endforeach
						<span timestamp="{{ $d->created_at }}"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="reply-content" id="comment-0-content">
					<p> {{ $d->content }} </p>
					@auth
						@if ($can_signature == "TRUE")
							@if ($u->signature != "")	
								<div class="forum-signature">
									{{ $u->signature }}
								</div>
							@endif
							
						@endif
					@endauth
				</div>
				@auth
				<div class="reply-actions">
					<a href="#leavecomment" onclick="quote('0')">Quote</a>
					@if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
						<a href="#" data-bs-toggle="modal" data-bs-target="#discussionEditModal">Edit</a>
						<a href="#" data-bs-toggle="modal" data-bs-target="#discussionMoveModal">Move</a>
						@if ($d->is_locked == TRUE)
						 	<a href="#" data-bs-toggle="modal" data-bs-target="#discussionUnlockModal">Unlock</a>
						@else
							<a href="#" data-bs-toggle="modal" data-bs-target="#discussionLockModal">Lock</a>
						@endif

						@if ($d->is_hidden == TRUE)
						 	<a href="#" data-bs-toggle="modal" data-bs-target="#discussionUnhideModal">Unhide</a>
						@else
							<a href="#" data-bs-toggle="modal" data-bs-target="#discussionHideModal">Hide</a>
						@endif
						<a href="#" data-bs-toggle="modal" data-bs-target="#discussionDeleteModal">Delete</a>
					@endif
					<a href="#" data-bs-toggle="modal" data-bs-target="#reportDiscussionModal">Report</a>
				</div>
				@endauth
			</li>
			@foreach ($comments as $c)
				<li class="forum-discussion-reply" id="comment-{{ $c->id }}">
					@foreach ($c['user'] as $m)
					    <div class="reply-member">
							<div class="reply-member-avatar">
								<a href="/member/{{ $m->username }}"><img src="{{asset('storage/avatars/' . $m->avatar)}}" /></a>
							</div>
							<div class="reply-member-meta">
								<h6><a href="/member/{{ $m->username }}" id="comment-{{ $c->id }}-username">{{ $m->username }}</a></h6>
								
					@endforeach
							<span timestamp="{{ $c->created_at }}"></span>
							</div>
						</div>
					<div class="clearfix"></div>
					<div class="reply-content" id="comment-{{ $c->id }}-content">
					<p>	{{ $c->content }} </p>
					@auth
						@if ($can_signature == "TRUE")
							@if ($m->signature != "")	
								<div class="forum-signature">
									{{ $m->signature }}
								</div>
							@endif
							
						@endif
					@endauth
					</div>
					@auth
					<div class="reply-actions">
						<a href="#leavecomment" onclick="quote('{{ $c->id }}')">Quote</a>
						@if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
							<a href="#" data-bs-toggle="modal" data-bs-target="#commentEditModal" data-bs-comment="{{ $c->id }}">Edit</a>
							<a href="#" data-bs-toggle="modal" data-bs-target="#commentDeleteModal" data-bs-comment="{{ $c->id }}">Delete</a>
						@endif
						<a href="#" data-bs-toggle="modal" data-bs-target="#reportCommentModal" data-bs-comment="{{ $c->id }}">Report</a>
					</div>
					@endauth
				</li>
			@endforeach
			
		</ul>
		<div id="lastreply"></div>
		@auth
			@if ($d->is_locked == TRUE && (auth()->user()->group === "admin" || auth()->user()->group === "mod"))
				<div class="card discussion-comment-card" id="leavecomment">
					<div class="card-header">
					    Leave a Comment
					</div>
					<div class="card-body">
						<form method="post" action="{{ route('discussion.reply') }}" class="discussion-comment-form">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="member" value="{{ auth()->user()->id }}" />
							<input type="hidden" name="discussion" value="{{ $d->id }}" />
							<input type="hidden" name="category" value="{{ $dc->id }}" />
							<input type="hidden" name="slug" value="{{ $d->slug }}" />

							<textarea class="form-control" id="reply" name="content" rows="4"></textarea>
							<button class="btn btn-primary float-end discussion-comment-button" type="submit"><i class="bi bi-reply"></i> Submit</button>
						</form>		
						
					</div>
				</div>
			@elseif ($d->is_locked == TRUE && auth()->user()->group === "member")
				<br><p>Discussion is closed - you can't comment.</p>
			@elseif ($d->is_locked == FALSE && auth()->user()->email_verified_at == "")
				<br><p><a href="/email/verify">Verify email</a> to comment.</p>
			@else
				<div class="card discussion-comment-card" id="leavecomment">
					<div class="card-header">
					    Leave a Comment
					</div>
					<div class="card-body">
						<form method="post" action="{{ route('discussion.reply') }}" class="discussion-comment-form">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="member" value="{{ auth()->user()->id }}" />
							<input type="hidden" name="discussion" value="{{ $d->id }}" />
							<input type="hidden" name="category" value="{{ $dc->id }}" />
							<input type="hidden" name="slug" value="{{ $d->slug }}" />


							<textarea class="form-control" id="reply" name="content" rows="4"></textarea>
							<button class="btn btn-primary float-end discussion-comment-button" type="submit"><i class="bi bi-reply"></i> Submit</button>
						</form>		
						
					</div>
				</div>
			@endif
			
		@endauth
		@guest
			<br><p><a href="/login">Sign in</a> or <a href="/register">Create account</a> to comment.</p>
		@endguest
		
		<div class="forum-pagination">
			{{ $comments->links() }}
		</div>

	@auth
		<!-- #reportCommentModal -->
		<div class="modal modal-lg fade" id="reportCommentModal" tabindex="-1" aria-labelledby="reportCommentLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="{{ route('report.comment') }}" class="">
					<div class="modal-header">
					<h1 class="modal-title fs-5" id="reportCommentLabel">Report Comment</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" id="commentID" value="" name="id_of_reported" />
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
		<!-- #reportDiscussionModal -->
		<div class="modal modal-lg fade" id="reportDiscussionModal" tabindex="-1" aria-labelledby="reportDiscussionLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="{{ route('report.discussion') }}" class="">
					<div class="modal-header">
					<h1 class="modal-title fs-5" id="reportDiscussionLabel">Report Discussion</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="id_of_reported" value="{{ $d->id }}" />
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
		@if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
			<!-- #discussionLockModal -->
			<div class="modal fade" id="discussionLockModal" tabindex="-1" aria-labelledby="discussionLockLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.lock') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionLockLabel">Lock Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Would you like to lock this discussion so members can no longer comment?</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionUnlockModal -->
			<div class="modal fade" id="discussionUnlockModal" tabindex="-1" aria-labelledby="discussionUnlockLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.unlock') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionUnlockLabel">Lock Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Would you like to unlock this discussion so members can comment?</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionHideModal -->
			<div class="modal fade" id="discussionHideModal" tabindex="-1" aria-labelledby="discussionHideLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.hide') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionHideLabel">Hide Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Would you like to hide this discussion from members?</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionUnhideModal -->
			<div class="modal fade" id="discussionUnhideModal" tabindex="-1" aria-labelledby="discussionUnhideLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.unhide') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionUnhideLabel">Unhide Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Would you like to unhide this discussion from members?</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionMoveModal -->
			<div class="modal fade" id="discussionMoveModal" tabindex="-1" aria-labelledby="discussionMoveLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.move') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionMoveLabel">Move Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Select a different category to which you wish to move this discussion:</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
						<select class="form-select" name="category" aria-label="Category">
							@foreach($categories->sortBy('order') as $cat)
								@if ($cat->id === $dc->id)
									<option selected value="{{ $cat->id }}">{{ $cat->section_name }} - {{ $cat->name }}</option>
								@else
									<option value="{{ $cat->id }}">{{ $cat->section_name }} - {{ $cat->name }}</option>
								@endif
							@endforeach
						</select>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionDeleteModal -->
			<div class="modal fade" id="discussionDeleteModal" tabindex="-1" aria-labelledby="discussionDeleteLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.delete') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionDeleteLabel">Delete Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<p>Are you sure you wish to delete this discussion? All comments will be deleted as well. This is permanent!</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-danger">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>
			<!-- #discussionEditModal -->
			<div class="modal modal-lg fade" id="discussionEditModal" tabindex="-1" aria-labelledby="discussionEditLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.edit') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="discussionEditLabel">Edit Discussion</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
					  	<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input class="form-control" type="text" id="title" name="title" value="{{ $d->title }}">
						</div>
						<div class="mb-3">
							<label for="edit" class="form-label">Content</label>
							<textarea class="form-control" id="edit" name="content" rows="4">{{ $d->content }}</textarea>
						</div>
						
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>

			<!-- #commentEditModal -->
			<div class="modal modal-lg fade" id="commentEditModal" tabindex="-1" aria-labelledby="commentEditLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.editComment') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="commentEditLabel">Edit Comment</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
						<textarea class="form-control" id="edit" name="content" rows="4"></textarea>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
						<input type="hidden" name="comment" id="commentID" value="" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>

			<!-- #commentDeleteModal -->
			<div class="modal modal-lg fade" id="commentDeleteModal" tabindex="-1" aria-labelledby="commentDeleteLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			    	<form method="post" action="{{ route('discussion.deleteComment') }}" class="">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5" id="commentDeleteLabel">Delete Comment</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				      	<p>Are you sure you wish to delete this comment? This is permanent!</p>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="slug" value="{{ $d->slug }}" />
						<input type="hidden" name="comment" id="commentID" value="" />
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-danger">Submit</button>
				      </div>
				  	</form>
			    </div>
			  </div>
			</div>


		@endif
	@endauth

	<script>
		function quote(comment) {
			var quoteUsername = document.getElementById('comment-' + comment + '-username').innerHTML;
			var quoteContent = document.getElementById('comment-' + comment + '-content').innerHTML;
			var quote = '<blockquote><p><a href="#comment-' + comment + '">' + quoteUsername + '</a>:</p>' + quoteContent + '</blockquote><p></p>';
			var textarea = document.getElementById("reply");
			textarea.insertAdjacentHTML("afterbegin",quote);
		}

	</script>
	<script>
		const reportCommentModal = document.getElementById('reportCommentModal')
		if (reportCommentModal) {
			reportCommentModal.addEventListener('show.bs.modal', event => {
		    const button = event.relatedTarget;
		    const comment = button.getAttribute('data-bs-comment');
		    const modalComment = reportCommentModal.querySelector('#commentID');
		    modalComment.value = comment;
		  });
		}
		
		const commentEditModal = document.getElementById('commentEditModal')
		if (commentEditModal) {
		  commentEditModal.addEventListener('show.bs.modal', event => {
		    const button = event.relatedTarget;
		    const comment = button.getAttribute('data-bs-comment');
		    const content = document.getElementById('comment-' + comment + '-content').innerHTML;
		    const modalContent = commentEditModal.querySelector('#edit');
		    const modalComment = commentEditModal.querySelector('#commentID');
		    modalContent.textContent = content;
		    modalComment.value = comment;
		  });
		}

		const commentDeleteModal = document.getElementById('commentDeleteModal')
		if (commentDeleteModal) {
		  commentDeleteModal.addEventListener('show.bs.modal', event => {
		    const button = event.relatedTarget;
		    const comment = button.getAttribute('data-bs-comment');
		    const modalComment = commentDeleteModal.querySelector('#commentID');
		    modalComment.value = comment;
		  });
		}
	</script>

@include('includes.footer')