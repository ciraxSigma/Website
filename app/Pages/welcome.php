<!DOCTYPE html>
<html>
    <head>
        <title>SimplePHPLib</title>
        <link rel="icon" type="image/x-icon" href="/images/logo.svg">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">

        <style>

        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #2e2e2e;
        }

        p {
            color: white;
            margin-top: 60px;
            font-family: 'Ubuntu', sans-serif;
            font-weight: 500;
            font-size: 1.4rem;
        }

        .main-container {
            flex-direction: column;
            display: flex;
            align-items: center;
            margin-top: 27vh;
        }

        .image-container {
            position: relative;
        }

        .shadow-center{
            position: absolute;
            border-radius: 50%;
            left: 48%;
            top: 55%;
            box-shadow: 0 0 150px 70px #17d4ff;
            width: 1px;
            height: 1px;
            z-index: -1;

        }

        .logo {
            animation: rotation 4s infinite linear;
        }

        @keyframes rotation {
            from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}
        }


        </style>

    </head>

    <body>

        <div class="main-container">

            <div class="image-container">
                <img src="images/logo.svg" alt="Library logo" class="logo" width="300" />
                <div class="shadow-center"></div>
            </div>

            <p class="description">This is Simple PHP Library which is inspired by Laravel framework.</p>




        </div>

    </body>
</html>