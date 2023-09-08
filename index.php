<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!--Boostrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!--css-->
  <link rel="stylesheet" href="css.css">
   <!--Vue 3-->
   <script src="https://unpkg.com/vue@next"></script>
   <!--Axios--> 
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="fondo body">
        <div id="app" class="card shadow p-3 mb-5 bg-white rounded" >
                <div class="card-header bg-success text-light">
                  <h4 class="text-center ">L O G I N</h4>
                </div>
                <div class="card-body">
                  <form @submit.prevent="verificar" >
                    <div class="form-group">
                        <label >Usuario</label>
                        <input type="text" v-model="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label >Contraseña</label>
                        <input type="password" v-model="password" class="form-control" required>
                    </div>
                      <div class="d-flex justify-content-center">
                          <button type="submit" class=" w-50 btn btn-primary btn-block">Acceder</button>
                    </div>
                  </form>
                    <div class="col-12 d-flex justify-content-center">
                          <label   class=" text-danger text-center w-100" :style="{ 'visibility': incorrecto == 1 ?  'visible' : 'hidden' ,'font-size': incorrecto == 1 ? '16px' : 'inherit' ,'font-weight': incorrecto == 1 ? 'bold' : 'normal'}">Contraseña Incorrecta</label>
                    </div>
                </div>
        </div>
         <!--Js-->
   <script src="js/login.js"></script>
  </body>
</html>