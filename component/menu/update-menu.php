<?php

include("../../config.php");
$id = $_GET["id"];

$data = mysqli_query($connection,"SELECT * FROM tb_menu WHERE id_menu = $id");
$row = mysqli_fetch_assoc($data);

function updateMenu($data)
{

    global $connection;

    $id = $data["id_menu"];
    $name = $data["name"];
    $price = $data["price"];
    $imageOld = $data["imageOld"];

    if($_FILES["image"]["error"] === 4){
        $image_menu = $imageOld;
    }else{
        $image_menu = imageMenu();
    }

    mysqli_query($connection, "UPDATE tb_menu SET
        name = '$name',
        price = '$price',
        image_menu = '$image_menu'
        WHERE id_menu = $id
    ");

    return mysqli_affected_rows($connection);
}

function imageMenu(){

    $nameFile = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $error = $_FILES["image"]["error"];

    // check if no images are uploaded
    if( $error === 4 ){
        echo "please upload image!";
    }

    // check extension image
    $extension = ["jpg","png","jpeg","jfif"];
    $extensionImage = explode(".",$nameFile);
    $extensionImage = strtolower(end($extensionImage));
    
    if( !in_array($extensionImage,$extension) ){
        echo "this file not image";
    }
    
    // change name image from default to random string
    $newName = uniqid();
    $newName .= ".";
    $newName .= $extensionImage;

    move_uploaded_file($tempName, '../../img/menu/' . $newName);

    return $newName;
}

if (isset($_POST["submit"])) {
    if (updateMenu($_POST) > 0) {
        header('location: menu-admin.php');
        echo "
        <script>
            alert('data berhasil di ubah')
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
</head>

</head>

<body class="w-full flex flex-col justify-center items-center  select-none font-alata">
    <nav class="w-full h-16 mb-8 drop-shadow-md border-b-4  flex justify-between items-center px-5">
        <div class="text-white">
            <a href="../admin/index.php" class="font-bold text-lg mr-4 hover:underline hover:underline-offset-8">Home</a>
            <a href="menu-admin.php" class="fa-solid fa-bars text-lg bg-coklat2 hover:bg-coklat3 py-3 px-3 rounded-lg"></a>
        </div>
        <div>
            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg font-sans hover:underline hover:underline-offset-8 ">Logout</a>
        </div>
    </nav>
    <div class="flex justify-center items-center w-full h-full">
        <form method="post" enctype="multipart/form-data" class="w-1/2 h-full border rounded-lg flex flex-col justify-center items-center py-12 mt-5 ">
            <input type="hidden" name="id_menu" value="<?= $row["id_menu"] ?>">
            <input type="hidden" name="imageOld" value="<?= $row["image_menu"] ?>">
            <div class="mb-5">
                <img src="../../img/coffee.png" class="h-52 w-52">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="text" name="name" value="<?= $row["name"] ?>" placeholder="Name" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-gray-400">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="number" name="price" value="<?= $row["price"] ?>" placeholder="Price" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-gray-400">
            </div>
            <div class="w-1/2 flex justify-start items-center my-2">
                <img src="../../img/menu/<?= $row["image_menu"] ?>" alt="" width="100">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="file" name="image" placeholder="Name" class="text-lg font-semibold file:rounded-lg file:border-none file:py-2 file:px-4 file:hover:bg-coklat file:bg-coklat3 file:font-semibold file:text-lg file:text-white">
            </div>
            <div class="w-1/2 flex justify-end items-center mb-2 mt-5">
                <button type="submit" name="submit" class="py-1 px-4 mr-2 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg">Submit</button>
                <a href="menu-admin.php" class="py-1 px-4 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg e">Back</a>
            </div>
        </form>
    </div>
</body>

</html>