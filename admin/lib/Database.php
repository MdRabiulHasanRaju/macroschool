<?php
    include $_SERVER['DOCUMENT_ROOT']."/macroschool/config/config.php";
    $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
    if(!$connection){
        echo "Database Connection Failed! ".mysqli_connect_error();
    }

    function fetch_data($connection,$input_sql){
      $sql = $input_sql;
      $stmt = mysqli_prepare($connection,$sql);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      return $stmt;
    }




?>