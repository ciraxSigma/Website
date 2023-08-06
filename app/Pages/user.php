<!DOCTYPE html>
<html>
    <head>
        <title>User</title>
    </head>
    <body>

        <h1>Input Page</h1>

        <form action="/users" method="POST">
            <input type="text" name="username" value="<?php echo old('username') ?>" placeholder="username">
            <input type="password" name="password" value="<?php echo old('password') ?>" placeholder="password">
            <input type="email" name="email" value="<?php echo old('email') ?>" placeholder="email">
            <button type="submit">Press me</button>
        </form>

        <?php if($usernameErr = invalid("username")): ?>
        
            <p style="color:red"><?php echo $usernameErr ?></p>

        <?php endif; ?>

    </body>
</html>