<?php
//catatan: fungsi buat enkripsi teks pakai AES dengan IV tetap
function enkripsi_teks_iv_tetap($plainteks, $kunci)
{
    $iv = "1234567890123456"; // IV tetap (16 bytes untuk AES-256-CBC)
    $cipherteks = openssl_encrypt($plainteks, 'aes-256-cbc', $kunci, OPENSSL_RAW_DATA, $iv);
    return base64_encode($cipherteks);
}
//catatan: fungsi buat dekripsi teks pakai AES dengan IV tetap
function dekripsi_teks_iv_tetap($cipherteks, $kunci)
{
    $iv = "1234567890123456"; // IV tetap (16 bytes untuk AES-256-CBC)
    $cipherteks = base64_decode($cipherteks);
    return openssl_decrypt($cipherteks, 'aes-256-cbc', $kunci, OPENSSL_RAW_DATA, $iv);
}
//catatan: inisialisasi variabelnya
$teks_input = "";
$kunci = "";
$teks_hasil = "";
$operasi = "";
//catatan: data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teks_input = $_POST["teks_input"];
    $kunci = $_POST["kunci"];
    $operasi = $_POST["operasi"];
    //catatan: menentukan enkripsi atau dekripsi
    if ($operasi == "encrypt") {
        $teks_hasil = enkripsi_teks_iv_tetap($teks_input, $kunci);
    } elseif ($operasi == "decrypt") {
        $teks_hasil = dekripsi_teks_iv_tetap($teks_input, $kunci);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enkripsi & Dekripsi</title>
</head>
<style>
    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    h2,
    label,
    input[type="text"],
    textarea {
        font-family: 'Roboto', sans-serif;
        font-weight: 550;
    }

    button {
        background-color: cyan;
        border: 1;
        border-radius: 5px;
    }
</style>

<body>
    <div class="container">
        <h2>Algoritma Kriptografi Modern - AES</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="teks_input">Masukan Teksnya:</label><br>
            <textarea id="teks_input" name="teks_input" rows="4"
                cols="50"><?php echo htmlspecialchars($teks_input); ?></textarea><br><br>
            <label for="kunci">Kunci:</label><br>
            <input type="text" id="kunci" name="kunci" value="<?php echo htmlspecialchars($kunci); ?>"><br><br>
            <input type="radio" id="encrypt" name="operasi" value="encrypt" checked>
            <label for="encrypt">Enkripsi</label><br>
            <input type="radio" id="decrypt" name="operasi" value="decrypt">
            <label for="decrypt">Dekripsi</label><br><br>
            <button type="submit">Submit</button><br><br>
        </form>
        <label for="hasil_teks">Hasil:</label><br>
        <textarea id="hasil_teks" rows="4" cols="50"
            readonly><?php echo htmlspecialchars($teks_hasil); ?></textarea><br><br>
    </div>
</body>

</html>