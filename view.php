<?php
  #check if session exists
  session_start();
  if ((!$_SESSION['UID']) && (!$_SESSION['GID']) && (!$_SESSION['gruppenname'])) {
    #if no session exists navigate to index.html to enforce login
    header("Location: index.html");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title><?php echo $_SESSION['gruppenname']; ?></title>
    <link href="view.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="bootstrap.min.css" crossorigin="anonymous"/>
  </head>
  <body>
    <div class="container">
      <div class="row mt-3">
        <div class="col-2">
          <a href="index.html"><img src="logo.png" alt="simpleWhatsApp" class="mw-100" width="100px" /></a>
        </div>
        <div class="col-6">
          <h1>
            <?php echo $_SESSION['gruppenname']; ?></h1>
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
            <form action='postMessage.php' method='post'> 
              <div class="row">
                <div class='col-8 mt-1 mx-1'>
                  <textarea class="form-control chatInputArea" aria-label="With textarea" name="message" required></textarea>
                </div>
                <div class='col-2 mt-4'>
                    <button type="submit" class="btn-primary">Senden</button>
                </div>
              </div>      
            </form>
        </div>
        <div class="col-4 coolBorder">
          <ul id = "OnlineStatus">
            <!-- <li>{{ name }}</li> -->
          </ul>
        </div>
      </div>
    </div>
  </body>
  <script type = "text/javascript" src="view.js"></script>
</html>
 