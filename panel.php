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
   <!--Tipo de letra-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <!--CARD-->
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet"> 
</head>

<body class="body-panel">
    <div class="container-fluid ">
            <div class="row cinta d-flex  align-items-start ">
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Bascula</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Registros Brutos</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Registros Finalizados</button></div>
                        <div class="col-6 col-lg-3 text-center"><button class="btn btn-menu">Usuarios</button></div>
            </div>
            <div class="bascula row d-flex justify-content-center align-items-center">
                        <div class="card  p-1 mb-5" >
                                <div class="card-body">
                                        <form @submit.prevent="verificar" >
                                                <div class="row buscar d-flex justify-content-center align-items-center mb-4  p-1 rounded-pill">
                                                        <div class=" col-2 ">
                                                           <img src="img/icono-buscar.png" class="img-responsive w-100" >
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" v-model="username" class="form-control rounded-pill input-alto" required>
                                                        </div>
                                                      
                                                </div>
                                            <div class="form-group">
                                                <label class="label-letra" >Productor</label>
                                                <input type="text" v-model="username" class="form-control rounded-pill input-alto" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="label-letra">Placas del Vehículo (Opcional)</label>
                                                <input type="password" v-model="password" class="form-control rounded-pill input-alto" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="label-letra">Peso Bruto</label>
                                                <input type="password" v-model="password" class="form-control rounded-pill input-alto" required>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class=" w-50 btn-aceptar rounded-pill btn-block">GUARDAR</button>
                                            </div>
                                        </form>
                                </div>
                        </div>
            </div>
    </div>
</body>
</html>
<?php
}else{
    header("Location:index.php");
}

?>