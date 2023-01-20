<?php

include('../../config.php');
session_start();
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    //check username
    $user = mysqli_query($connection, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");
    $data = mysqli_fetch_assoc($user);
    $data_id = $data["id_user"];
    if (mysqli_num_rows($user) === 1) {
        // check level
        if ($data["level"] == "admin") {
            $_SESSION["admin"] = $username;
            $_SESSION["id_admin"] = $data_id;
            echo "
            <script>
                document.location.href ='../menu/menu-admin.php'
                alert('berhasil login')
            </script>
            ";
        }else if($data["level"] == "kasir"){
            $_SESSION["kasir"] = $username;
            $_SESSION["id_kasir"] = $data_id;
            echo "
            <script>
                document.location.href = '../transaksi/index.php'
                alert('berhasil login')
            </script>
            ";
        }else if($data["level"] == "user"){
            $_SESSION["user"] = $username;
            $_SESSION["id_user"] = $data_id;
            echo "
            <script>
                document.location.href = './user-menu.php'
                alert('berhasil login')
            </script>
            ";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VodaResto</title>
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <div class="w-full h-screen">
        <div class="flex justify-center items-center">
            <div class="w-2/5 h-2/6 bg-coklat2 flex flex-col mt-20">
                <div class="body flex flex-col justify-center items-center w-full mt-10">
                    <div class="my-4">
                        <img src="../../img/coffee.png" class="h-52 w-52">
                    </div>
                    <form action="" method="POST" class="w-1/2">
                        <div class="py-2 w-full flex flex-col justify-center items-center">
                            <input type="text" name="username" placeholder="Username" class="w-full py-3 px-2 font-semibold focus:outline-none">
                        </div>
                        <div class="py-2 w-full flex flex-col justify-center items-center">
                            <input type="password" name="password" placeholder="Password" class="w-full py-3 px-2 font-semibold focus:outline-none">
                        </div>
                        <div class="py-2 w-full flex justify-center items-center mb-5">
                            <button type="submit" name="submit" class="bg-coklat3 py-1 px-4 text-white font-bold text-lg hover:bg-coklat4 hover:text-black duration-300">
                                Login
                            </button>
                            <a href="./auth/register.php" class="bg-coklat3 py-1 px-4 text-white font-bold text-lg hover:bg-coklat4 hover:text-black duration-300 mx-2">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>