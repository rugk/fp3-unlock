<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FP3 'verify code' generator</title>
  </head>
  <body>
    <h2>FP3 'verify code' generator</h2>

    <p>A big thanks to <a href="https://forum.fairphone.com/t/oem-unlock-input-verify-code/56231/11?u=z3ntu" target="_blank">_tmp in the Fairphone Forum</a> for the code behind this site!</p>

    <p>Enter the IMEI (slot 1) and serial number values from your phone and press submit.</p>
    <p>You can find those numbers under "About phone" - "Model &amp; hardware" in the Settings app.</p>

    <form method="post">
      IMEI1:<br>
      <input type="text" name="imei"><br>
      Serial:<br>
      <input type="text" name="serial"><br>
      <input type="submit" value="Submit">
    </form>

    <?php
    if (isset($_POST["imei"]) && isset($_POST["serial"])) {
      $imei = $_POST["imei"];
      $serial = $_POST["serial"];
      if(strlen($imei) != 15 || strlen($serial) < 10) {
        print("<h3>IMEI must be 15 characters and serial must be longer than 10 characters.</h3>");
        return;
      }
      $key = $imei . $serial;
      $md5 = md5($key);

      $chk = 0;
      for ($i = 0; $i < 8; $i++) {
        $chk += ord(substr($md5,$i,1)) * 256**($i%4);
      }
      $chk &= 0xFFFFFFFF;
      print("<h3>Code: " . dechex($chk) . "</h3>");
    }
    ?>
  </body>
</html>
