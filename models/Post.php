<?php

    use Framework\Models\Model;

    require('./../Testing.php');

    class Post extends Model{

        protected $table = "posts";
    }

    $post = new Post();

    $post->create(array(
        'userId' => 2,
        'title' => "I love car else",
        'excerpt' => 'This is monument',
        'body' => 'I love pussy'
    ));

?>