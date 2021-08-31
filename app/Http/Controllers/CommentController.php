<?php
namespace App\Http\Controllers;
use App\Models\Comment;
class CommentController extends Controller
{

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    
    public function index()
    {
        $comments = $this->comment->getData();
        return view('answer',['comments' => $comments]);
    }

    public function actionReply()
    {
        if (!empty($_POST["comment"])) {
            $comment = $_POST["comment"];
            $userId = auth()->user()->id;
            $parentId = $_POST["parentId"];
            $commentArr = [
                "comment" => $comment,
                "user_id" => $userId,
                "parent_id" => $parentId
                
            ];
            $this->comment->pushData($commentArr);   
            $commentData = $this->comment->getReplyData();
            return response()->json($commentData);
        } else {
            $commentErr = 'Заполните поле';
            $validationErrors['commentErr'] = $commentErr;
            return response()->json($validationErrors);
        }
    }
}





