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
        // var_dump($_FILES);
        // echo '</pre>';
        // exit;

        $errors = [];

        $title = '';
        $description = '';
        $price = '';

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $date = date('Y-m-d H-i-s');

            if (!$title) {
                $errors[] = 'Product title is required';
            }
       
            if (!$price) {
                $errors[] = 'Product price is required';
            }
       
            if (!is_dir('images')) {
                mkdir('images');
            };

            if (empty($errors)) {

                $image = $_FILES['image'] ?? null;
                $imagePath = '';


                if ($image && $image['tmp_name']) {

                    $imagePath = 'images/'.time().'/'.$image['name'];
                    mkdir(dirname($imagePath));

                    move_uploaded_file($image['tmp_name'], $imagePath);
                }
                

                $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date) 
                VALUES (:title, :image, :description, :price, :date)");

                $statement->bindValue(':title', $title);
                $statement->bindValue(':image', $imagePath);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':price', $price);
                $statement->bindValue(':date', $date);
                $statement->execute();
                header('Location: index.php');
            
            }
        }

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

    ?>

    <div class="container">

        <h1 class="pt-3">Creat New Product</h1>

        <div class="mb-3">
        <a href="index.php" class="btn btn-primary btn-md mt-3">Go Back To products</a>
        </div>

        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <dib><?php echo $error.'<br>' ?></dib>
                <?php endforeach; ?>
            </div>
        <?php endif ?>

        <form method="POST" action="create.php" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="image" class="form-label">Choose a Product image</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Product title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Product description</label>
                <textarea name="description" id="description" class="form-control" value="<?php echo $description ?>"></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Product price</label>
                <input type="number" class="form-control" step=".01" name="price" id="price" value="<?php echo $price ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

</body>

</html>