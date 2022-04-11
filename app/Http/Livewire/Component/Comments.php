<?php

namespace App\Http\Livewire\Component;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class Comments extends BaseLive
{
    public $modelId, $editId, $replyId;
    public $invalidPostBtn=true;
    public $mode;
    public $newComment,$editComment, $replyComment;
    public $perPage = 5;
    public $totalCommentsCount=0;
    public $post_id;

    public function mount($post_id = null){
        $this->post_id = $post_id;
    }

    public function render()
    {
        $comments= Comment::query();
        $comments->where('post_id', $this->post_id)->orderBy('comments.created_at','desc');
        $this->totalCommentsCount=$comments->count();
        $comments=$comments->whereNull('parent_id')//->with('children', 'user')
            ->get();

        return view('livewire.component.comments',[
            'comments' => $comments
        ]);
    }
    public function loadComment($id, $class){
        $this->modelId=$id;
        $this->class=$class;
        $this->resetValidate();
    }

    public function postComment()
    {
        # code...
        if ($this->newComment != null) {
            $comment = new Comment();
            $comment->comment = $this->newComment;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $this->post_id;
            $comment->save();

            $this->reset(['newComment', 'replyId']);
            $this->emit('focus-on-input', 'new');
        }
    }

    public function edit($id){
        $this->replyId='';
        $this->mode='edit';
        $this->editId=$id;
        $comment = Comment::findOrFail($id);
        if($comment){
            $this->editComment= $comment->comment;
        }
    }

    public function update()
    {
        $comment = Comment::findOrFail($this->editId);
        if($comment){
            $comment->update([
                'comment' => $this->editComment
            ]);
        }
        $this->reset(['mode', 'editId']);
    }

    public function reply($id){
        $this->editId='';
        if($id==$this->replyId){
            $this->mode='';
            $this->replyId='';
        }
        else {
            $this->mode='reply';
            $this->replyId=$id;
        }
        $this->emit('focus-on-input', 'reply');
    }

    public function saveReply()
    {
        # code...
        if ($this->replyComment != null) {
            $reply = new Comment();
            $reply->comment = $this->replyComment;
            $reply->user_id = Auth::user()->id;
            $reply->post_id = $this->post_id;
            $reply->parent_id = $this->replyId;
            $reply->save();

            $this->reset(['replyComment']);
            $this->emit('focus-on-input', 'reply');

        }
    }

    public function destroy($id)
    {
        $this->deleteId = $id;
        $this->emit('open-modal-delete');
    }

    public function delete()
    {
        Comment::find($this->deleteId)->delete();
        $this->reset('deleteId');
    }

    public function cancelEdit(){
        $this->reset('editId');
    }

    public function cancelReply(){
        $this->reset('replyId');
    }

    public function cancelDelete(){
        $this->reset('deleteId');
    }
}
