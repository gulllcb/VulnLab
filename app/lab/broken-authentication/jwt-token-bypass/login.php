<?php
require("../../../lang/lang.php");
$strings = tr();
require_once('config.php');
$jwt = (new JWT());
require_once("DBconnect.php");

session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {

  $q = $db->prepare("SELECT * FROM users WHERE username=:user AND password=:pass");
  $q->execute(array(
    'user' => $_POST['username'],
    'pass' => md5($_POST['password'])
  ));
  $_select = $q->fetch();
  if (isset($_select['id'])) {
    $_SESSION['username'] = $_select['username'];
    $_SESSION['id'] = $_select['id'];

    // JWT IMP
    $payload = [
      'id' => $_select['id'],
      'username' => $_select['username'],
      'iss' => 'test.jwt',
      'aud' => 'test.jwt'
    ];
    $token = $jwt->generate($payload);
    setcookie("auth_type", $token);

    header("Location: index.php");
    exit;
  }
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= $strings["title"]; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= $strings["login"]; ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= $strings["username"]; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= $strings["password"]; ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= $strings["submit"]; ?></button>
                <p class="mt-3"><?= $strings["hint"]; ?></p>
            </form>


        </div>
    </div>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>


</body>

</html>