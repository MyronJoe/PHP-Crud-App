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

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // var_dump($product);
        // echo '</pre>';
        // exit;


        $errors = [];

        $title = $product['title'];
        $description = $product['description'];
        $price = $product['price'];

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];

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
                $imagePath = $product['image'];


                if ($image && $image['tmp_name']) {

                    if ($product['image']) {
                        unlink($product['image']);
                    }

                    $imagePath = 'images/'.time().'/'.$image['name'];
                    mkdir(dirname($imagePath));

                    move_uploaded_file($image['tmp_name'], $imagePath);
                }
                

                $statement = $pdo->prepare("UPDATE products SET title = :title', image = :image, description = :description, price = :price WHERE id = :id");
                $statement->bindValue(':title', $title);
                $statement->bindValue(':image', $imagePath);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':price', $price);
                $statement->bindValue(':id', $id);
                $statement->execute();
                header('Location: index.php');
            
            }
        }

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

    ?>

    <div class="container">

        <h1 class="pt-3">Update Product <b><?php echo $product['title'] ?></b></h1>

        <div class="mb-3">
        <a href="index.php" class="btn btn-success btn-md mt-3">Go Back To products</a>
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
                <?php if ($product['image']): ?>
                    <img height="150px" width="150px" style="object-fit: cover;" src="<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>">
                <?php endif?>
            </div>


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