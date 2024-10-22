<?php 
  // Finally mari alhamdulillah
  session_start() ;
  session_destroy() ; 
  echo  "<script>
           alert('Anda telah log Out.');
           window.location='login.php';
         </script>";
?>