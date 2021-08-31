<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $fillable = [
        'parent_id',
        'user_id',
        'message'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function pushData($params)
    {
        $this->create([
            'message' => $params["comment"],
            'user_id' => $params["user_id"],      
            'parent_id' => $params["parent_id"]
        ]);
    }

    public function getData()
    {    
        $comments = $this->join('users','comments.user_id','=','users.id')->select('comments.*','users.name')->get()->toArray();
        $shownComments = $this->sortComments($comments);
        $commentReplyData = $shownComments;
        return $commentReplyData;
    }
    public function getReplyData()
    {
        $commentGet = $this->join('users', 'comments.user_id','=','users.id')->select('users.name','comments.*')->latest('id')->first()->toArray();
        return $commentGet;
    }
    public function sortComments($comments, $parentId = NULL, &$result = [], &$depth = 0)
    {
        foreach ($comments as $key => $value) {
            if ($value['parent_id'] == $parentId) {
                $value['depth'] = $depth;
                array_push($result, $value);
                unset($comments[$key]);
                $oldParent = $parentId;
                $parentId = $value['id'];
                $depth++;
                $this->sortComments($comments, $parentId, $result, $depth);
                $parentId = $oldParent;
                $depth--;
            }
        }
        return $result;
    }

 }