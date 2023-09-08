<?php
session_start();
if(isset($_SESSION['nombre'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Bascula</title>
    <!--Boostrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!--css-->
  <link rel="stylesheet" href="css.css">
   <!--Vue 3-->
   <script src="https://unpkg.com/vue@next"></script>
   <!--Axios--> 
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <div id="container-fluid">
            <div class="row cinta">
                    
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Bascula</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Registros Brutos</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Registros Finalizados</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Usuarios</button></div>
                  
            </div>
    </div>
</body>
</html>
<?php
}else{
    header("Location:index.php");
}

?>