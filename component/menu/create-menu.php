<?php

include("../../config.php");
session_start();
if ($_SESSION["admin"] == "") {
    header('location: ../user/index.php');
}
// var_dump($_FILES);
// die;

function imageMenu(){

    $nameFile = $_FILES["image_name"]["name"];
    $tempName = $_FILES["image_name"]["tmp_name"];
    $error = $_FILES["image_name"]["error"];

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

function createMenu($data)
{

    global $connection;

    $name = $data["name"];
    $price = $data["price"];
    $image_name = imageMenu();

    if(!$image_name){
        return false;
    }

    // var_dump($image_name);
    // die;
    mysqli_query($connection, "INSERT INTO tb_menu VALUES(
        '',
        '$name',
        '$price',
        '$image_name'
    )");

    return mysqli_affected_rows($connection);
}

if (isset($_POST["submit"])) {
    if (createMenu($_POST) > 0) {
        header('location: menu-admin.php');
        echo "
        <script>
            alert('data berhasil di tambahkan')
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

<body class="w-full flex flex-col justify-center items-centerbg-yellow-300 select-none font-alata">
    <nav class="w-full h-16 mb-8  flex justify-between items-center px-5 drop-shadow-md border-b-4">
        <div class="text-white">
            <a href="../admin/index.php" class="font-bold text-lg mr-4 hover:underline hover:underline-offset-8">Home</a>
            <a href="menu-admin.php" class="fa-solid fa-bars text-lg bg-coklat2 hover:bg-coklat3 py-3 px-3 rounded-lg"></a>
        </div>
        <div>
            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg font-sans hover:underline hover:underline-offset-8 ">Logout</a>
        </div>
    </nav>
    <div class="flex justify-center items-center w-full h-full">
        <form method="post" action="" enctype="multipart/form-data" class="w-1/2 h-full border  rounded-lg flex flex-col justify-center items-center py-12 mt-5 ">
            <div class="mb-5">
            <img src="../../img/coffee.png" class="h-52 w-52">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="text" name="name" placeholder="Name" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-gray-400">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="number" name="price" placeholder="Price" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-gray-400">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="file" name="image_name" placeholder="Name" class="text-lg font-semibold file:rounded-lg file:border-none file:py-2 file:px-4 file:hover:bg-coklat2 file:bg-coklat3 file:font-semibold file:text-lg file:text-white">
            </div>
            <div class="w-1/2 flex justify-end items-center mb-2 mt-5">
                <button type="submit" name="submit" class="py-1 px-4 mr-2 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg ">Submit</button>
                <a href="menu-admin.php" class="py-1 px-4 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg ">Back</a>
            </div>
        </form>
    </div>
</body>

</html>