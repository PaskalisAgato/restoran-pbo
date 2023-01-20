<?php

include('../../config.php');
function register($data){
    global $connection;

    $username = $data["username"];
    $password = $data["password"];
    $status = $data["status"];
    
    // check username
    $name = mysqli_query($connection,"SELECT * FROM tb_user WHERE username = '$username'");
    if(mysqli_fetch_assoc($name)){
        echo "
        <script>
            alert('username sudah terpakai')
        </script>
        ";
        return false;
    }

    // add data to database
    mysqli_query($connection,"INSERT INTO tb_user VALUES (
        '',
        '$username',
        '$password',
        '$status'
        )
    ");

    return mysqli_affected_rows($connection);
}

if(isset($_POST["submit"])){
    if(register($_POST) > 0){
        echo"
        <script>
            alert('data berhasil di tambahkan')
            document.location.href = '../user/index.php'
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
    <title>Register | Page</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <link rel="shortcut icon" href="./../img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
</head>
<body class="">
    <div class="w-full h-screen flex justify-center items-center">
        <form method="post" action="" class="w-1/3 h-2/3 border border-gray-200  flex flex-col items-center py-4 bg-coklat2">
            <img src="../../img/coffee.png" alt="" class=" h-40 w-40">
            <input type="hidden" name="status" value="user">
            <div class="py-2 w-2/3">
                <input type="text" name="username" id="" placeholder="Username" class="w-full py-3 px-2 font-semibold focus:outline-none ">
            </div>
            <div class="py-2 w-2/3">
                <input type="password" name="password" id="" placeholder="Password" class="w-full py-3 px-2 font-semibold focus:outline-none ">
            </div>
            <div class="py-2 w-2/3 justify-center items-center flex">
                <a href="../user/index.php" type="submit" class="bg-coklat3 mr-2 py-1 px-4 font-bold text-lg  hover:bg-gray-300 hover:scale-110 hover:text-black duration-300 text-white ">
                    Back
                </a>
                <button type="submit" name="submit" class="bg-coklat3 text-white py-1 px-4 font-bold text-lg  hover:bg-gray-300 hover:text-black hover:scale-110 duration-300">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>
</html>