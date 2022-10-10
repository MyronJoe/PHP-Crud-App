<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>PHP-Crude-App</title>
</head>

<body>

    <?php

        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';

    ?>

    <div class="container">

        <h1 class="pt-3">Creat New Product</h1>

        <div>
        <a href="index.php" class="btn btn-primary btn-lg">Go Back To Products</a>
        </div>

        

    </div>

</body>

</html>