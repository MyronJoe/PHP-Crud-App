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

        $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';

    ?>

    <div class="container">

        <h1 class="pt-3">Products CRUD</h1>

        <div>
        <a href="create.php" class="btn btn-warning btn-md">Create Product</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S/N</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Create Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product): ?>
                        <tr>
                            <th scope="row"><?php echo $key + 1 ?></th>
                            <td>
                            <img style="width: 50px; height:50px; object-fit: cover;" src="<?php echo $product['image'] ?>" alt="<?php echo $product['title'] ?>">
                            </td>
                            <td><?php echo $product['title'] ?></td>
                            <td><?php echo $product['price'] ?></td>
                            <td><?php echo $product['create_date'] ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm">Edit</button>

                                <form action="delete.php" method="POST" style="display:inline-block;">

                                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                    <button  type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    
                                </form>
                                
                            </td>
                        </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>

</body>

</html>