<?php
ob_start();
?>
<html>
<body>
  <h1>New Page</h1>
</body>
<html>
<?php
file_put_contents('new_page.html', ob_get_contents());  
ob_end_flush();
?>
