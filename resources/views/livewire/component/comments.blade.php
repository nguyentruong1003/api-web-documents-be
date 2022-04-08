<div>
    <div class="d-flex align-items-center justify-content-center bg-white py-3" >
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-12">
                    <h4 class="text-black">{{ "Comments ({$totalCommentsCount})"}}</h4>
                </div>
            </div>
            <!-- New Comment Section -->
            @auth
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="comment-form d-flex align-items-center">
                            <div class="flex-shrink-0 align-self-start">
                                <div class="avatar avatar-sm rounded-circle">
                                    <img class="avatar-img rounded-circle border" height="50" src="" alt="">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-2 ms-sm-3">
                                <!-- onkeyup="toggleButton(this,'Responding ');" -->
                                <textarea id="myTextarea"
                                          class="form-control py-0 px-1 border-1 @error('newComment') is-invalid @enderror"
                                          rows="2" placeholder="Start writing..." style="resize: none;"
                                          wire:model.lazy="newComment">
                                </textarea>
                                @error('newComment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <button class="btn btn-sm bg-purple text-white mt-3"  {{--$invalidPostBtn ?'disabled': ''--}}
                                wire:click="postComment">Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a class="btn btn-sm btn-primary text-white mt-2" href="{{route('login')}}">Add Comment
                </a>
        @endauth
        <!-- Heading-->
            
            <!-- Heading Ends -->
            <!-- All Comments Section-->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-12">
                    <div class="comments" wire:key="comments">
                        @forelse($comments as $comment)
                            <div class="comment d-flex mb-4" wire:key="{{ $comment->id }}">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle border" height="50" src="" alt="">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2 ms-sm-3">
                                    <div class="comment-meta d-flex align-items-baseline">
                                        <h6 class="me-2 font-weight-bold">{{ $comment->users->name }}</h6>
                                        <span
                                            class="text-muted ml-3">{{ $comment->created_at ? $comment->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                    @if ($editId == $comment->id)
                                        <div class="d-flex border ">
                                            <input
                                                class="form-control py-0 px-1 border-0 @error('editComment') is-invalid @enderror"
                                                style="resize: none;" wire:model.lazy="editComment">
                                            <button wire:click="update()" type="button"
                                                    class="btn btn-primary-outline text-primary font-medium">
                                                <i class="nav-icon fas fa-save"></i>
                                            </button>
                                            <button wire:click="cancelEdit()" type="button"
                                                    class="btn btn-primary-outline text-primary font-medium">
                                                <i class="nav-icon fas fa-window-close"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="comment-body text-wrap text-break ml-4">
                                            {{ $comment->comment }}
                                        </div>
                                        <div>
                                            <button wire:click="reply({{ $comment->id }})" type="button"
                                                    class="btn btn-primary-outline text-primary font-medium">Reply
                                            </button>
                                            @if (auth()->id() == $comment->user_id)
                                                <button wire:click="edit({{ $comment->id }})" type="button"
                                                        class="btn btn-primary-outline text-success font-medium">

                                                    Edit
                                                </button>
                                                <button wire:click="destroy({{ $comment->id }})" type="button"
                                                        class="btn btn-primary-outline text-danger font-medium">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11" style="margin-left: 7%">
                                    @if ($replyId == $comment->id)
                                        <div class="d-flex border" style="margin: -1% 0% 2% -4%">
                                            <input
                                                class="form-control py-0 px-1 border-0 @error('replyComment') is-invalid @enderror input-reply"
                                                style="resize: none;" wire:model.lazy="replyComment">
                                            <button wire:click="saveReply()" type="button"
                                                    class="btn btn-primary-outline text-primary font-medium" {{$replyComment ?'' :'disabled'}}>
                                                <i class="nav-icon fas fa-plus"></i>
                                            </button>
                                            <button wire:click="cancelReply()" type="button"
                                                    class="btn btn-primary-outline text-primary font-medium">
                                                <i class="nav-icon fas fa-window-close"></i>
                                            </button>
                                        </div>
                                    @endif
                                    @foreach ($comment->reply as $commentReply)
                                        <div class="comment d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <div class="avatar avatar-sm">
                                                    <img class="avatar-img rounded-circle border" height="50" src=""
                                                         alt="">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2 ms-sm-3">
                                                <div class="comment-meta d-flex align-items-baseline">
                                                    <h6 class="me-2 font-weight-bold">{{ $commentReply->users->name }}</h6>
                                                    <span
                                                        class="text-muted ml-3">{{ $commentReply->created_at ? $commentReply->created_at->diffForHumans() : '' }}</span>
                                                </div>
                                                <div class="comment-body text-wrap text-break ml-4">
                                                    {{ $commentReply->comment }}
                                                </div>
                                                @if ($editId == $commentReply->id)
                                                    <div class="d-flex border ">
                                                        <input
                                                            class="form-control py-0 px-1 border-0 @error('editComment') is-invalid @enderror"
                                                            style="resize: none;" wire:model.lazy="editComment">
                                                        @error('editComment')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        <button wire:click="update()" type="button"
                                                                class="btn btn-primary-outline text-primary font-medium" {{$editComment ?'' :'disabled'}}>
                                                            <i class="nav-icon fas fa-save"></i>
                                                        </button>
                                                        <button wire:click="cancelEdit()" type="button"
                                                                class="btn btn-primary-outline text-primary font-medium">
                                                            <i class="nav-icon fas fa-window-close"></i>
                                                        </button>
                                                    </div>
                                                    
                                                @else
                                                    <div>
                                                        @if (auth()->id() == $commentReply->user_id)
                                                            <button wire:click="edit({{ $commentReply->id }})"
                                                                    type="button"
                                                                    class="btn btn-primary-outline text-success font-medium">
                                                                Edit
                                                            </button>
                                                            <button wire:click="destroy({{ $commentReply->id }})"
                                                                    type="button"
                                                                    class="btn btn-primary-outline text-danger font-medium">
                                                                Delete
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @empty
                            <div class="text-center">
                                <img src="/images/illustrations/comment.png" alt="no comments" height="400"
                                     class="mt-n5"/>
                                <p class="text-cyan fs-4"> It's so empty out here, go ahead and post some comments</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- All Comments Section Ends-->

        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="modal-delete-comment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">{{ __('common.confirm_message.confirm_title') }}</h3>
                </div>
                <div class="modal-body">
                    {{ __('common.confirm_message.are_you_sure_delete') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="cancelDelete()">Hủy</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="delete()">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.livewire.on('focus-on-input', (data) => {
            if (data == 'new') {
                $('#myTextarea').focus();
            } else if (data == 'reply') {
                $('.input-reply').focus();
            }
        });
        window.livewire.on('open-modal-delete', () => {
            $('#modal-delete-comment').modal('show');
        });
    </script>
</div>
