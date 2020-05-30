<?php
  session_start();
  if ((!$_SESSION['UID']) && (!$_SESSION['GID']) && (!$_SESSION['gruppenname'])) {
    header("Location: index.html");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?php echo $_SESSION['gruppenname']; ?></title>
    <link href="../assets/css/view.css" rel="stylesheet" type="text/css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="container">
      <div class="row mt-3">
        <div class="col-2">
          <img src="../assets/img/logo.png" alt="simpleWhatsApp" class="mw-100" width="100px" />
        </div>
        <div class="col-6">
          <h1><?php echo $_SESSION['gruppenname']; ?></h1>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-8">
          <div class="coolBorder chatTextArea" id = "ChatWindow">
            <div class="row">
              <div class="col-2"></div>
              <div class="col-2"></div>
              <div class="col-8"></div>
            </div>
          </div>
          <div class="input-group mt-3">
            <textarea class="form-control chatInputArea" aria-label="With textarea"></textarea>
            <div class="input-group-prepend">
              <button type="submit" class="btn-primary">Senden</button>
            </div>
          </div>
        </div>
        <div class="col-4 coolBorder">
          <ul id = "OnlineStatus">
            <!-- <li>{{ name }}</li> -->
          </ul>
        </div>
      </div>
    </div>
  </body>
  <script type = "text/javascript" src="../assets/js/view.js"></script>
</html>
