<?php

    namespace App\Models;

    use Framework\Models\Model;
    use App\Models\Comment;
    use App\Models\User;

    class Post extends Model{

        protected static $table = "posts";

        public function comments(){
            return $this->hasMany(Comment::class, 'id', 'postId');
        }

        public function user(){
            return $this->belongsTo(User::class, 'userId', 'id');
        }

    }

?>