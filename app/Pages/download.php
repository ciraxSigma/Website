<!DOCTYPE html>
<html>
    <head>
        <title>Lazar</title>
    </head>

    <body>
        <form action="/upload" method="POST" enctype="multipart/form-data">

            <input type="file" name="image" />
            <button type="submit">Submit!</button>

        </form>

        <br>

        <h1>Download link</h1>

        <a href="/download?file=kafa.jpg">Slika</a>
    </body>
</html>