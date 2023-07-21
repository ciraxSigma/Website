<?php

    namespace App\Models;

    use Framework\Models\Model;

    use App\Models\Post;
    use App\Models\Comment;

    class User extends Model{

        protected static $table = "users";

        public function posts(){

            return $this->hasMany(Post::class, "id", "userId");

        }

        public function comments(){
            return $this->hasMany(Comment::class, "id", "userId");
        }
    }

?>