<?php

include("../../config.php");
session_start();
if ($_SESSION["user"] == "") {
    header("location: index.php");
}

function createCart($data){
    global $connection;
    $id_user = $data["id_user"];
    $id_menu = $data["id_menu"];
    $quantity = $data["quantity"];
    $total = $quantity * $data["price"];

    mysqli_query($connection,"INSERT INTO tb_cart VALUES(
        '',
        '$id_menu',
        '$id_user',
        '$quantity',
        '$total'
    )");

    return mysqli_affected_rows($connection);
}

$show_menu = mysqli_query($connection, "SELECT * FROM tb_menu");

if(isset($_POST["add-to-cart"])){
    if(createCart($_POST) > 0 ){
        echo "
        <script>
            alert('keranjang di tambahkan')
            document.location.href = 'user-menu.php'
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html class="scroll-smooth" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABCD Coffee</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
</head>

<body class="w-full flex flex-col justify-center items-center select-none font-alata">
    <nav class="w-full h-16 flex justify-between items-center px-5">
        <div class="text-white">
            <i class="fa-solid fa-bars  border bg-coklat py-3 px-3 rounded-lg"></i>
            <a href="../user/user-index.php" class="font-bold text-lg mr-4 hover:underline hover:underline-offset-8">Home</a>
        </div>
        <div class="text-center ml-24">
            <p class="text-center text-4xl font-italiana">Coffee</p>
        </div>
        <div>
            <a href="#order1" class="border border-black py-3 px-4 text-lg bg-black hover:bg-neutral-700 text-white ">ORDER</a>

            <a href="cart.php" class="fa-solid fa-cart-shopping text-lg mr-4 border border-black py-4 px-3 bg-black hover:bg-neutral-700 text-white"></a>

            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg hover:underline text-black hover:underline-offset-8 ">Logout</a>
        </div>
    </nav>
    <div class="bg-[url('../../img/bg3.png')] py-40 w-full opacity-90 -z-10 ">
        <div class="flex items-center flex-col">
            <p class="text-white text-4xl font-alata mb-5">WELCOME TO</p>
            <p class="text-white text-6xl font-alata mb-5">ABCD COFFE</p>
            <p class="text-white text-2xl font-alata mb-5">Lorem ipsum dolor sit amet consectetur adipisicing.</p>

            <a href="" class="text-white">ORDER HERE</a>
        </div>
    </div>
    <div class="mt-10 mb-5 flex flex-col items-center ">
        <p class="text-4xl font-alata">Why should choose us?</p>
        <p class="text-2x1 text-coklat2">________________</p>
    </div>
    <div class="flex justify-center items-center mb-20">
        <div class="flex items-center flex-col mr-20">
            <img src="../../img/sketsa1.png" class=" ">
            <p class="w-40 text-center">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem, ipsa.</p>
        </div>
        <div class="flex items-center flex-col mr-20">
            <img src="../../img/sketsa1.png" class="">
            <p class="w-40 text-center">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem, ipsa.</p>
        </div>
        <div class="flex items-center flex-col mr-20">
            <img src="../../img/sketsa1.png" class="">
            <p class="w-40 text-center">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem, ipsa.</p>
        </div>
        <div class="flex items-center flex-col">
            <img src="../../img/sketsa1.png" alt="">
            <p class="w-40 text-center">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem, ipsa.</p>
        </div>
    </div>
    <div class="py-10 w-full border bg-coklat flex justify-center items-center mb-20 gap-20">
            <div class="text-5xl px-16 ">
                <p class="mb-5">Made with</p>
                <p class="mb-5">sophisticated</p>
                <p class="mb-5">machines and</p>
                <p class="mb-5">experts</p>
            </div>
            <div>
                <img src="../../img/mesin.png" class="w-11/12 h-96 border ">
            </div> 
    </div>
    <!-- order here -->
    <div id="order1" class="flex flex-col items-center mb-10">
        <p class="text-4xl ">OUR COFFEE</p>
        <p class="text-2x1 text-coklat2 ">___________</p>
    </div>
    <div class="container w-full h-full grid grid-cols-3 gap-14 px-32 mb-20 ">
        <?php while ($row = mysqli_fetch_assoc($show_menu)) : ?>
            <form method="post" class="flex flex-col py-2 px-4 border-b-4 border-gray-300">
                <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"] ?>">
                <input type="hidden" name="id_menu" value="<?= $row["id_menu"] ?>">
                <input type="hidden" name="price" value="<?= $row["price"] ?>">
                <div class="flex flex-col items-center">
                <img src="../../img/menu/<?= $row["image_menu"] ?>" class="my-2 rounded-full h-52 w-52" alt="">
                
                    <div class="flex flex-col h-full ">
                        <span class=" text-2xl"><?= $row["name"] ?></span>
                    </div>
                    <div class="w-full flex justify-center  items-center " >
                        <span class="text-coklat2 text-2xl py-2 ">Rp<?= $row["price"] ?></span>
                        <input type="number" name="quantity" id="" value="1" class="w-10 py-1 font-semibold text-gray-800 text- text-center border border-coklat3 ml-2 ">
                    </div>
                    <div class="w-full my-3 flex flex-col items-center">
                        
                        <button type="submit" name="add-to-cart" class="w-1/2 bg-coklat2 py-1 hover:bg-coklat3 text-lg text-white duration-300">
                            ORDER
                        </button>
                    </div>
                </div>
            </form>
        <?php endwhile ?>
    </div>
    <div class="flex justify-center items-center ">
        <p class="text-3xl text-coklat2">________________</p>
        <img src="../../img/Ellipse4.png" class="">
        <p class="text-3xl text-coklat2">________________</p>
    </div>
    <div class="grid grid-cols-3 gap-7">
        <img src="../../img/Rectangle16.png" class="h-80 w-80">
        <img src="../../img/Rectangle17.png" class="h-80 w-80">
        <img src="../../img/Rectangle18.png" class="h-80 w-80">
        <img src="../../img/Rectangle19.png" class="h-80 w-80">
        <img src="../../img/Rectangle20.png" class="h-80 w-80">
        <img src="../../img/Rectangle21.png" class="h-80 w-80">
    </div>
    <div class="mt-40 flex flex-col items-center mb-5 ">
        <p class="text-6xl font-italiana">ABCD Coffee</p>
        <p class="text-3xl font-italiana mb-20 text-coklat3">Coffee and Art</p>
        <p class="text-2xl">Follow and Contact us</p>
    </div>
    <div class="flex justify-items-center gap-10 text-3xl text-coklat3 mb-3">
        <i class="fa-brands fa-tiktok"></i>
        <i class="fa-brands fa-facebook-f"></i>
        <i class="fa-brands fa-instagram"></i>
        <i class="fa-brands fa-twitter"></i>
        <i class="fa-brands fa-whatsapp"></i>
    </div>
    <div class="flex justify-center w-full py-4 bg-coklat2">
            <p class="text-white">All rights reserved. © Copyright</p>
    </div>
</body>

</html>