<?php

include("../../config.php");
session_start();
if ($_SESSION["admin"] == "") {
    header('location: ../user/index.php');
}

$show_user = mysqli_query($connection,"SELECT * FROM tb_user");

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

<body class="w-full flex flex-col justify-center items-center  select-none">
    <nav class="w-full h-16 mb-8 drop-shadow-md border-b-4 border-gray-300 flex justify-between items-center px-5">
        <div class="text-white">
            <a href="../menu/menu-admin.php" class="fa-solid fa-bars text-lg bg-coklat2 hover:bg-coklat3 py-3 px-3 rounded-lg"></a>
        </div>
        <div>
            <a href="./index-user.php" class="fa-sharp fa-solid fa-user text-lg hover:underline hover:underline-offset-8 text-white py-4 px-4 mr-2 bg-black"></a>
            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg font-sans hover:underline hover:underline-offset-8 ">Logout</a>
        </div>
    </nav>
    <div>
        <p class="font-italiana text-5xl mb-10">Edit User</p>
    </div>
    <table class="border border-black text-center">
            <thead>
                <tr class="text-lg">
                    <th class="w-1/5 border-b-2 border-r-2 py-2 border-gray-500">Username</th>
                    <th class="w-1/5 border-b-2 border-r-2 py-2 border-gray-500">Status</th>
                    <th class="w-1/5 border-b-2 border-r-2 py-2 border-gray-500">Action</th>
                </tr>
            </thead>
            <div class="container w-full h-full grid grid-cols-4 gap-4 text-center">
                <?php while ($row = mysqli_fetch_assoc($show_user)) : ?>

                    <tr>  
                        <td class="py-2 border-b-2 border-r-2 border-gray-500 font-semibold text-lg"><?= $row["username"] ?></td>
                        <td class="py-2 font-semibold border-b-2 border-r-2 text-lg border-gray-500 "><?= $row["level"] ?></td>
                        <td class="py-2 font-semibold border-b-2 border-r-2 text-lg border-gray-500 ">
                        <a href="delete-user.php?id=<?= $row["id_user"] ?>" class="text-red-700 hover:text-red-800 duration-300">
                        delete /
                        </a>
                        <a href="update-user.php?id=<?= $row["id_user"] ?>" class="text-coklat3 hover:text-coklat duration-300">edit</a>
                    </td>
                </tr>
                <?php endwhile ?>
            </div>
        </table >
</body>

</html>