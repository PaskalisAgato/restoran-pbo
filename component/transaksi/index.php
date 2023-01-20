<?php

include "../../config.php";
session_start();

$transactions = mysqli_query($connection,
    "SELECT * FROM tb_transaksi
    INNER JOIN tb_user ON tb_transaksi.id_user = tb_user.id_user"
);

function changeStatus($data)
{
    global $connection;

    $id_transaksi = $data["id_transaksi"];
    mysqli_query($connection,"UPDATE tb_transaksi SET status = '1' WHERE id_transaksi = '$id_transaksi'");
    return mysqli_affected_rows($connection);
}

if(isset($_POST["submit"]))
{
    if(changeStatus($_POST) > 0)
    {
        header("location:index.php");
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

<body class="w-full flex flex-col justify-center items-center bg-coklat2 select-none font-alata">
    <nav class="w-full h-16 mb-8  bg-coklat3 border-gray-300 flex justify-between items-center px-5 bg-fixed">
        <div>
            <a href="../auth/logout.php" onclick="return confirm('yakin ingin logout?')" class="font-bold text-lg font-sans hover:underline hover:underline-offset-8 text-white">Logout</a>
        </div>
    </nav>
    <div class="container flex justify-center items-center flex-col gap-5">
        <?php while ($row = mysqli_fetch_assoc($transactions)) : ?>
            <div class="w-2/3 h-full flex flex-col p-10 border border-black bg-white">
                <div class="flex flex-row text-center mb-2">
                    <span class="font-bold text-xl ">Pembeli</span>&nbsp;
                    <span class="font-bold text-xl ">:</span>&nbsp;
                    <span class="font-bold text-xl "> <?= $row["username"] ?></span>
                </div>
                <div class="flex flex-row text-center mb-2">
                    <span class="font-bold text-xl ">Menu</span>&nbsp;
                    <span class="font-bold text-xl ">:</span>&nbsp;
                    <span class="font-bold text-xl "><?= $row["menu"] ?></span>
                </div>
                <div class="flex flex-row text-center mb-2">
                    <span class="font-bold text-xl ">Total</span>&nbsp;
                    <span class="font-bold text-xl ">:</span>&nbsp;
                    <span class="font-bold text-xl ">Rp <?= $row["total"] ?></span>
                </div>
                <div class="flex flex-row text-center mb-2">
                    <span class="font-bold text-xl ">Status</span>&nbsp;
                    <span class="font-bold text-xl ">:</span>&nbsp;
                    <?php
                    if ($row["status"] == '0') {
                        echo "
                        <span class='font-bold text-xl text-red-500' >
                            Belum Bayar
                        </span>
                        ";
                    } else {
                        echo "
                        <span class='font-bold text-xl text-green-500'>
                            Lunas
                        </span>
                        ";
                    }
                    ?>
                </div>
                <form action="" method="post" class="flex flex-row justify-end items-end -mb-2 mt-2">
                    <input type="hidden" name="id_transaksi" value="<?= $row["id_transaksi"] ?>">
                    <button name="submit" class="py-1 px-4 bg-coklat2 font-semibold text-lg hover:bg-coklat3 duration-300">Bayar</button>
                    <a href="delete.php?id-transaksi=<?= $row["id_transaksi"] ?>" class="py-1 px-4 bg-coklat3 font-semibold text-lg hover:bg-coklat2 duration-300 ml-2 text-white" onclick="return confirm('ingin menghapus transaksi?')">Delete</a>
                </form>
            </div>
        <?php endwhile ?>
    </div>
</body>

</html>