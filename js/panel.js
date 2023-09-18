const app = {
    data(){
        return{
          idProductor:'',
          nombre:'',
          pesobruto: '',
          pesotara: '',
          pesoneto: '',
          pagar:'',
          opcionUno:1,
          opcionDos:0,
          opcionTres:0,
          opcionCuatro:0,
          productor:'',
          cajas:'',
          resultados: [],
          registrosBrutos: [],
          registrosFinalizados: [],
          mostrarInput:0,
          usuarios: [],
          selector_tipo:'Usuario',
          nombre_usuario:'',
          nuevo_usuario:'',
          password:'',
          myModal:'',
          nombre_actualizar:'',
          usuario_actualizar:'',
          password_actualizar:'',
          selector_tipo_actualizar:'',
          idActualizar:''
        }
    },mounted(){

    },methods:{
        guardarPeso(){
          
            if (this.mostrarInput == 1 && this.pesotara==0  || this.mostrarInput == 1 && this.pagar == 0) {
                 alert("¿Tara o total a pagar esta vacio asi desea continuar?")
            }else{
                    axios.post("guardarPeso.php",{
                            productor:this.productor,
                            cajas:this.cajas,
                            pesobruto:this.pesobruto,
                            pesotara:this.pesotara,
                            pesoneto:this.pesoneto,
                            pagar:this.pagar,
                            bandera:this.mostrarInput,
                            id:this.idProductor
                    }).then(response=>{
                            console.log(response.data);
                            if(response.data ==true){
                            alert("guardado con exito")
                            this.mostrarInput =0
                            this.idProductor=""
                            this.resultados = [];
                            this.nombre=""
                            this.productor=""
                            this.cajas=""
                            this.pesobruto=''
                            this.pesotara= ''
                            this.pesoneto=''
                            this.pagar=''
                            }else{
                                alert('Algo salio mal :-(')
                            }
                    }).catch(error=>{
                        console.log("Error :-("+error)
                    }).finally(()=>{

                    })
                }
        },
        /*toUpperCase() {
                    this.cajas = this.cajas.toUpperCase();
          },*/
          buscarDatosAutocompletado() {
                if(this.nombre!=''){
                            axios.post("buscarProductor.php",{
                                nombre:this.nombre
                            }).then(response=>{
                                console.log(response.data);
                                this.resultados=response.data
                                    if(this.resultados.leght>0){
                                        this.resultados = response.data;
                                    }else{
                                    console.log("Vacio")
                                    }
                        }).catch(error=>{
                            console.log("Error :-("+error)
                        }).finally(()=>{

                        })
                }else{
                    this.mostrarInput =0
                    this.idProductor=""
                    this.resultados = [];
                    this.nombre=""
                    this.productor=""
                    this.cajas=""
                    this.pesobruto=''
                    this.pesotara= ''
                    this.pesoneto=''
                    this.pesoneto=''

                }
                    
          },
          seleccionarResultado(idProductor){
              this.resultados = [];
              this.consultadoDatosProductorSeleccionado(idProductor)
          },
          consultadoDatosProductorSeleccionado(idProductor){
               axios.post("productorSeleccionado.php",{
                id:idProductor
               }).then(response => {
                    console.log(response.data)
                    if(Object.keys(response.data).length>0){
                        this.mostrarInput =1
                        this.nombre = response.data.productor
                        this.idProductor=response.data.id
                        this.productor=response.data.productor
                        this.cajas=response.data.cajas
                        this.pesobruto=response.data.peso_bruto
                        this.pesotara=response.data.tara
                        this.pesoneto=response.data.neto
                        this.pagar=response.data.pagar
                    }else{
                        alert("No se encontreo el productor seleccionado")
                            this.productor=''
                            this.cajas=''
                            this.pesobruto=''
                            this.pesotara= ''
                            this.pesoneto=''
                            this.pagar=''
                    }
               }).catch(error => {
                    console.log('Axios Error: ' + error);
               })
          },
          limpiar(){
              this.mostrarInput =0
                this.nombre=""
                this.productor=""
                this.cajas=""
                this.pesobruto=''
                this.pesotara= ''
                this.pesoneto=''
                this.pagar=''
          },
          restarTaraBruto(){
            this.pesoneto=this.pesobruto-this.pesotara;
          },
          consultarRegistrosBrutos(){
                    axios.post("consultarRegistrosBrutos.php",{
                    }).then(response=>{
                        console.log(response.data)
                        this.registrosBrutos = response.data;
                }).catch(error=>{
                    console.log("Error :-("+error)
                }).finally(()=>{

                }) 
        },
        consultarRegistrosFinalizados(){
            axios.post("consultarRegistrosFinalizados.php",{
            }).then(response=>{
                console.log(response.data)
                this.registrosFinalizados = response.data;
            }).catch(error=>{
                    console.log("Error :-("+error)
            }).finally(()=>{

            }) 
        },
        consultarUsuarios(){
            axios.post("consultarUsuarios.php",{
            }).then(response=>{
                console.log(response.data)
                this.usuarios = response.data;
            }).catch(error=>{
                    console.log("Error :-("+error)
            }).finally(()=>{

            }) 
        },
        guardarNuevoUsuario(){

            axios.post("guardarUsuario.php",{
                nombre:this.nombre_usuario,
                usuario:this.nuevo_usuario,
                contrasena:this.password,
                tipo:this.selector_tipo
            }).then(response=>{
                console.log(response.data)
                if(response.data==true){
                    this.consultarUsuarios()
                    this.nombre_usuario
                    this.nuevo_usuario
                    this.password
                    this.selector_tipo
                    
                }else{
                        alert("No se guardado el usuario correctamente, intentalo nuevamente :-( ")
                }
            }).catch(error=>{
                    console.log("Error :-("+error)
            }).finally(()=>{

            }) 
          

        },
        eliminarUsuario(id){
            if (confirm("¿Desea eliminar al usuario?")) {
                axios.post("eliminarUsuario.php",{
                    id:id
                }).then(response=>{
                    console.log(response.data)
                    if(response.data==true){
                         this.consultarUsuarios()
                    }else{
                        alert("No se elimino, intentalo nuevamente ")
                    }
                }).catch(error=>{
                        console.log("Error :-("+error)
                }).finally(()=>{

                }) 
            }
        },
        buscarUsuario(id){
          this.myModal = new bootstrap.Modal(document.getElementById('modal'));
          this.myModal.show ();
          this.idActualizar = id
                axios.post("buscarUsuario.php",{
                    id: this.idActualizar
                    }).then(response=>{
                        console.log(response.data)
                        if(Object.keys(response.data).length>0){

                            this.nombre_actualizar=response.data.nombre
                            this.usuario_actualizar=response.data.usuario
                            this.password_actualizar=response.data.contrasena
                            this.selector_tipo_actualizar=response.data.tipo
                          
                        }else{
                            alert("No se encontro Usuario")
                        }
                      
                    }).catch(error=>{
                            console.log("Error :-("+error)
                    }).finally(()=>{

                    }) 
        },
        closeModal(){
            this.myModal.hide ();
        },
        actualizarUsuario(){
                  axios.post("actualizarUsuario.php",{
                        id: this.idActualizar,
                        nombre:this.nombre_actualizar,
                        usuario:this.usuario_actualizar,
                        password:this.password_actualizar,
                        tipo:this.selector_tipo_actualizar
                      }).then(respon=>{
                          console.log(respon.data)
                          if(respon.data==true){
                                this.myModal.hide()
                                this.nombre_actualizar=''
                                this.usuario_actualizar=''
                                this.password_actualizar=''
                                this.selector_tipo_actualizar=''
                                this.consultarUsuarios()
                          }else{
                              alert("No se actualizo el usuario")
                          }
                        
                      }).catch(error=>{
                              console.log("Error :-("+error)
                      }).finally(()=>{
  
                      }) 
          },
          opcionNoValida(){
            alert("Solo para usuarios tipo Administrador.")
          }
    }
}

var mountedApp = Vue.createApp(app).mount('#app');
