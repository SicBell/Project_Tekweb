<!doctype html>
<html lang="en">

<head>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #EA906C;
        }

        .card {
            width: 500px;
            /* Set your desired width */
            height: 600px;
            /* Make it square */
        }

        #btn-send{
            background-color: #F8F0E5;
        }

        #btn-send:hover {
            background-color: #EADBC8;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style=" background-color: #FFC5C5;">


    <div class="card">
        <div class="card-header" style="background-color: #E0F4FF">
            Forgot Password
        </div>
        <div class="card-body" style="background-color: #F4BF96;">
            <form method="post" action="send-password-reset.php">

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                </div>

                <input id="btn-send" class="btn" type="submit" value="Send">

            </form>
        </div>
    </div>


</body>

</html>