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
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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
    <div id="app" class="container-fluid ">
 
            <div class="row cinta d-flex  align-items-start ">
                        <div class="col-6 col-lg-3 text-center" @click="opcionUno=1,opcionDos=0,opcionTres=0,opcionCuatro=0"><button class="btn" :class="opcionUno === 1 ? 'btn-menu-activo' : 'btn-menu'">Bascula</button></div>
                        <div class="col-6 col-lg-3 text-center" @click="opcionUno=0,opcionDos=1,opcionTres=0,opcionCuatro=0,consultarRegistrosBrutos()"><button class="btn"  :class="opcionDos=== 1? 'btn-menu-activo' : 'btn-menu'" >Registros Brutos</button></div>
                        <div class="col-6 col-lg-3 text-center" @click="opcionUno=0,opcionDos=0,opcionTres=1,opcionCuatro=0,consultarRegistrosFinalizados()"><button class="btn"  :class="opcionTres=== 1? 'btn-menu-activo' : 'btn-menu'">Registros Finalizados</button></div>
                            <?php if($_SESSION['tipo']=="Admin"){
                                ?>
                                     <div class="col-6 col-lg-3 text-center" @click="opcionUno=0,opcionDos=0,opcionTres=0,opcionCuatro=1,consultarUsuarios()"><button class="btn"  :class="opcionCuatro=== 1? 'btn-menu-activo' : 'btn-menu'">Usuarios</button></div>
                                <?php
                                    }else{
                                    ?>
                                       <div class="col-6 col-lg-3 text-center" ><button class="btn btn-menu-desactivado" @click="opcionNoValida()">Usuarios</button></div>
                           
                                    <?php    
                                    } 
                         ?>
                       
            </div>
            <div v-if="opcionUno" class="bascula row d-flex justify-content-center align-items-center">
                        <div class="card  p-1 mb-5 " >   
                                <div class="card-body">
                                                <div class="row buscar d-flex justify-content-center align-items-center mb-4  p-1 rounded-pill">
                                                        <div class=" col ">
                                                           <img src="img/icono-buscar.png" class="img-responsive w-100" >
                                                        </div>
                                                        <div :class="{'col-10':mostrarInput==0,'col-8':mostrarInput==1}">
                                                            <input type="text" v-model="nombre"  class="form-control rounded-pill input-alto"  @input="buscarDatosAutocompletado" required>                 
                                                        </div>
                                                         <div class="col"  :class="{'d-none ': mostrarInput==0, 'd-block' : mostrarInput==1}" >
                                                            <button class=" btn-limpiar rounded-pill btn-block py-2 px-2 w-100" title="limpiar todos los campos" @click="limpiar()">X</button>
                                                         </div>
                                                </div>
                                                        <div v-if="resultados.length" class="lista-autocompletado"  >
                                                                <li v-for="resultado in resultados" :key="resultado.id " class="opcion-lista mt-1 rounded-pill p-1 px-2 bg-primary text-white" @click="seleccionarResultado(resultado.id)">
                                                                    {{ resultado.productor }}
                                                                </li>
                                                        </div>
                                        <form @submit.prevent="guardarPeso" >
                                            <div class="form-group">
                                                <label class="label-letra" >Productor</label>
                                                <input type="text" v-model="productor" class="form-control rounded-pill input-alto" required :disabled="mostrarInput  == 1">
                                            </div>
                                            <div class="form-group">
                                                <label class="label-letra">Cajas (Pzas.)</label>
                                                <input type="number" v-model="cajas" step="1.0" class="form-control rounded-pill input-alto"   required :disabled="mostrarInput  == 1">
                                            </div>
                                            <div class="form-group  text-center">
                                                <label class="label-letra">Peso Bruto  (Kg)</label>
                                                <input type="number" v-model="pesobruto" step="1.0" class="form-control  text-center rounded-pill input-alto" required :disabled="mostrarInput  == 1">
                                            </div>
                                            <div class="form-group text-center" :class="{'d-none ': mostrarInput==0, 'd-block' : mostrarInput==1}">
                                                <label class="label-letra">Peso Tara  (Kg)</label>
                                                <input type="number" v-model="pesotara" step="1.0"  min="0" class="form-control rounded-pill input-alto text-center" :required="mostrarInput  == 1" @input="restarTaraBruto">
                                            </div>
                                            <div class="form-group text-center  label-neto " :class="{'d-none ': mostrarInput==0, 'd-block' : mostrarInput==1}">
                                                <label class="label-letra">PESO NETO  (Kg)</label>
                                                <input type="number" v-model="pesoneto" step="1.0" class="form-control rounded-pill  input-neto" :required="mostrarInput  == 1"disabled>
                                            </div>     
                                            <div class="form-group text-center  label-neto " :class="{'d-none ': mostrarInput==0, 'd-block' : mostrarInput==1}">
                                                <label class="label-letra">TOTAL A PAGAR $</label>
                                                <input type="number" v-model="pagar" step="1.0"  min="0"  class="form-control rounded-pill  input-neto" :required="mostrarInput  == 1">
                                            </div>      
                                            <div class="d-flex justify-content-center text-center">
                                                <button type="submit" class=" w-50 btn-aceptar rounded-pill btn-block">GUARDAR</button>
                                            </div>
                                        </form>
                                </div>
                        </div>
            </div>
            <div v-if="opcionDos" class="registros-brutos row d-flex justify-content-center align-items-center">
                      <div class="col-12 scroll m-5">
                            <table class="table table-success table-striped table-bordered  table-sm">
                                    <thead class="bg-success text-white text-center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Productor</th>
                                            <th scope="col">Cajas</th>
                                            <th scope="col">Peso Bruto</th>
                                            <th scope="col">Fecha peso Bruto</th>
                                            <th scope="col">Finalizar Peso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="registrosBrutos.length==0">
                                                <th colspan="6"  class="text-center" scope="row">No existen registros por el momento</th>
                                        </tr>
                                        <tr v-else v-for="(registrobruto, index) in registrosBrutos" >
                                                <th  class="text-center align-middle ">{{index+1}}</th>
                                                <td class="text-center align-middle">{{registrobruto.productor}}</td>
                                                <td class="text-center align-middle">{{registrobruto.cajas}} (Pzas.)</td>
                                                <td class="text-center align-middle">{{registrobruto.peso_bruto}} (Kg.)</td>
                                                <td class="text-center align-middle">{{registrobruto.fecha_dma}}</td>
                                                <td>  <button type="button" class="mx-auto w-50 btn-tablas rounded-pill btn-block" 
                                                @click="opcionUno=1,opcionDos=0,opcionTres=0,opcionCuatro=0,seleccionarResultado(registrobruto.id)">Pesar Tara</button></td>
                                        </tr>
                                    </tbody>
                            </table>
                    </div>
            </div>
            <div v-if="opcionTres" class="registros-finalizados row d-flex justify-content-center align-items-center">
                      <div class="col-12 scroll m-5">
                            <table class="table table-success table-striped table-bordered table-sm">
                                    <thead class="bg-success text-white text-center">
                                        <tr >
                                            <th scope="col">#</th>
                                            <th scope="col">Productor</th>
                                            <th scope="col">Cajas</th>
                                            <th scope="col">Peso Bruto</th>
                                            <th scope="col">Tara</th>
                                            <th scope="col">Fecha peso Tara</th>
                                            <th scope="col">Neto</th>
                                            <th scope="col">Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="registrosFinalizados.length==0">
                                                <th colspan="8"  class="text-center" scope="row">No existen registros por el momento</th>
                                        </tr>
                                        <tr v-else v-for="(registrofinalizados, index) in registrosFinalizados">
                                                <th  class="text-center " scope="row">{{index+1}}</th>
                                                <td>{{registrofinalizados.productor}}</td>
                                                <td class="text-center">{{registrofinalizados.cajas}} (Pzas.)</td>
                                                <td class="text-center">{{registrofinalizados.peso_bruto}} (Kg.)</td>
                                                <td class="text-center">{{registrofinalizados.tara}} (Kg.)</td>
                                                <td class="text-center">{{registrofinalizados.fecha_dma}}</td>
                                                <td class="text-center">{{registrofinalizados.neto}} (Kg.)</td>
                                                <td class="text-center">${{registrofinalizados.pagar}}</td>
                                        </tr>
                                    </tbody>
                            </table>
                    </div>
            </div>
            <div v-if="opcionCuatro" class="registros-finalizados row d-flex justify-content-center align-items-center">
                            <div class="col-12 col-lg-5 mt-5">
                                    <div class="card  p-1 mb-5 mx-auto" >   
                                            <div class="card-body ">
                                                            <div class="row d-flex justify-content-center align-items-center text-success font-weight-bold">
                                                                    <label >NUEVO USUARIO</label>
                                                            </div>
                                                            <div class="row d-flex justify-content-center align-items-center text-success font-weight-bold">
                                                                    <img src="img/perfil.png" class="img-responsive w-25"/>
                                                            </div>
                                                        <form @submit.prevent="guardarNuevoUsuario" >
                                                                <div class="form-group">
                                                                        <label class="label-letra" >Nombre</label>
                                                                        <input type="text" v-model="nombre_usuario" class="form-control rounded-pill input-alto" required >
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="label-letra" >Usuario</label>
                                                                        <input type="text" v-model="nuevo_usuario" class="form-control rounded-pill input-alto" required >
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="label-letra">Password</label>
                                                                        <input type="text" v-model="password" class="form-control rounded-pill input-alto" required>
                                                                </div>
                                                                <div class=" text-group">
                                                                        <label class="label-letra">Tipo</label>
                                                                        <select class="form-control selector rounded-pill bordered-secondary" v-model="selector_tipo">
                                                                                <option  value="Admin">Admin</option>
                                                                                <option  value="Usuario">Usuario</option>
                                                                        </select>
                                                                </div>
                                                                <div class="d-flex justify-content-center text-center">
                                                                        <button type="submit" class="mt-5 w-50 btn-aceptar rounded-pill btn-block">GUARDAR</button>
                                                                </div>
                                                        </form>
                                                </div>
                                        </div>
                             </div>
                             <div class="col-12 col-lg-7">
                                        <div class="col-12 scroll">
                                                <table class="table table-success table-striped table-bordered table-sm">
                                                        <thead class="bg-success text-white text-center">
                                                            <tr >
                                                                <th scope="col">#</th>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Usuario</th>
                                                                <th scope="col">Password</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Actualizar</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-if="usuarios.length==0">
                                                                    <th colspan="6"  class="text-center" scope="row">No existen registros por el momento</th>
                                                            </tr>
                                                            <tr v-else v-for="(usuario, index) in usuarios" >
                                                                    <th  class="text-center align-middle " scope="row">{{index+1}}</th>
                                                                    <td   class="text-center align-middle ">{{usuario.nombre}}</td>
                                                                    <td   class="text-center align-middle ">{{usuario.usuario}}</td>
                                                                    <td class="text-center align-middle ">{{usuario.contrasena}}</td>
                                                                    <td class="text-center  align-middle ">{{usuario.tipo}}</td>
                                                                    <td class="text-center align-middle">
                                                                    <button type="button" class="mx-auto w-50 btn-tablas-update rounded-pill btn-block" 
                                                                             @click="buscarUsuario(usuario.id)">Actualizar</button>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <button  v-if="usuario.tipo=='Usuario'" type="button" class="mx-auto w-50 btn-tablas-eliminar rounded-pill btn-block"  @click="eliminarUsuario(usuario.id)">Eliminar</button>
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                </table>
                                            </div>
                            </div>


                            <!--Modal Actualizar-->
                                <div id="modal" class="modal" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header mx-auto">
                                                    <h5 class="modal-title mx-3 ">Actualizar Usuario</h5>
                                                    <button type="button" class="rounded-pill px-3 py-1  border-0" data-dismiss="modal"  aria-label="Close" @click="closeModal()"><b>X</b></button>
                                                </div>
                                                <div class="modal-body mx-auto">
                                                    <div class="col-12">
                                                                            <div class="card-body ">
                                                                                            <div class="row d-flex justify-content-center align-items-center text-success font-weight-bold">
                                                                                            </div>
                                                                                            <div class="row d-flex justify-content-center align-items-center text-success font-weight-bold">
                                                                                                    <img src="img/perfil-actualizar.png" class="img-responsive w-25"/>
                                                                                            </div>
                                                                                        <form @submit.prevent="actualizarUsuario()" >
                                                                                                <div class="form-group">
                                                                                                        <label class="label-letra" >Nombre</label>
                                                                                                        <input type="text" v-model="nombre_actualizar" class="form-control rounded-pill input-alto" required >
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                        <label class="label-letra" >Usuario</label>
                                                                                                        <input type="text" v-model="usuario_actualizar" class="form-control rounded-pill input-alto" required >
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                        <label class="label-letra">Password</label>
                                                                                                        <input type="text" v-model="password_actualizar" class="form-control rounded-pill input-alto" required>
                                                                                                </div>
                                                                                                <div class=" text-group">
                                                                                                        <label class="label-letra">Tipo</label>
                                                                                                        <select class="form-control selector rounded-pill bordered-secondary" v-model="selector_tipo_actualizar">
                                                                                                                <option  value="Admin">Admin</option>
                                                                                                                <option  value="Usuario">Usuario</option>
                                                                                                        </select>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-around ">
                                                                                                        <button class="mt-5 w-25 btn-salir rounded-pill btn-block ">Salir</button>
                                                                                                        <button type="submit" class="mt-5 w-25 btn-actualizar rounded-pill btn-block">Actualizar</button>
                                                                                                </div>
                                                                                        </form>
                                                                                </div>
                                                            </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                            <!--Fin Modal-->
            </div>
            <footer >
                <div class="col-12 d-flex  justify-content-end" >
                      <?php echo "<label class='text-success font-weight-bold mr-1' > Usuario:  </label><u><b> ".$_SESSION['usuario']."</b></u>";?></b>
                </div>
         </footer>
    </div>
     <!--JS--> 
   <script src="js/panel.js"></script>
</body>
</html>
<?php
}else{
    header("Location:index.php");
}

?>