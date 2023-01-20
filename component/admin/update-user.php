<?php

include("../../config.php");
session_start();
if ($_SESSION["admin"] == "") {
    header('location: ../user/index.php');
}
$id = $_GET["id"];
$data = mysqli_query($connection,"SELECT * FROM tb_user WHERE id_user = $id");
$row = mysqli_fetch_assoc($data);

function updateUser($data){
    global $connection;
    $id = $data["id"];
    $username = $data["username"];
    $level = $data["level"];
    $password = $data["password"];
    
    if($level === ""){
        echo"
        <script>
            alert('harap isi status user')
        </script>
        ";
        return false;
    }

    mysqli_query($connection,"UPDATE tb_user SET
        username = '$username',
        level = '$level',
        password = '$password'
        WHERE id_user = $id
    ");

    return mysqli_affected_rows($connection);
}

if(isset($_POST["submit"])){
    if(updateUser($_POST) > 0){
        header("location: index-user.php");
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
<body class="w-full flex flex-col justify-center items-center b select-none">
    <nav class="w-full h-16 mb-8 drop-shadow-md border-b-4 border-gray-300 flex justify-between items-center px-5">
        <div class="text-white">
            <a href="../admin/index.php" class="font-bold text-lg mr-4 hover:underline hover:underline-offset-8">Home</a>
            <a href="menu-admin.php" class="fa-solid fa-bars text-lg bg-coklat2 hover:bg-coklat3 py-3 px-3 rounded-lg"></a>
        </div>
        <div>
        <a href="./index-user.php" class="fa-sharp fa-solid fa-user text-lg hover:underline hover:bg-neutral-700 text-white py-4 px-4 mr-2 bg-black"></a>
            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg font-sans hover:underline hover:underline-offset-8 ">Logout</a>
        </div>
    </nav>
    <div class="flex justify-center items-center w-full h-full">
        <form method="post" action="" enctype="multipart/form-data" class="w-1/2 h-full rounded-lg flex flex-col justify-center items-center py-12 mt-5 ">
            <input type="hidden" name="id" value="<?= $row["id_user"] ?>">
            <div class="mb-5">
                <img src="../../img/coffee.png" class="h-52 w-52">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="text" name="username" value="<?= $row["username"] ?>" placeholder="Name" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-black">
            </div>
            <div class="w-full flex justify-center items-center my-2">
                <input type="text" name="password" value="<?= $row["password"] ?>" placeholder="Password" class="w-1/2 py-2 px-4 font-semibold text-lg focus:outline-none border border-black">
            </div>
            <div class="w-1/2 flex justify-center items-center my-2 border border-gray-400">
                <select name="level" id="" class="w-full py-2 px-4 outline-none font-semibold text-lg rounded-lg">
                    <option value="">--</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="w-1/2 flex justify-center items-center mb-2 mt-5">
                <button type="submit" name="submit" class="py-1 px-4 mr-2 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg  ">Submit</button>
                <a href="index-user.php" class="py-1 px-4 bg-coklat2 hover:bg-coklat3 duration-300 font-semibold text-lg  ">Back</a>
            </div>
        </form>
    </div>
</body>
</html>