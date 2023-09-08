const app = {
    data(){
        return{
            username:'',
            password:'',
            incorrecto:0
        }
    },mounted(){

    },methods:{
        verificar(){
            axios.post("verificar.php",{
                username:this.username,
                password:this.password
            }).then(response=>{
                console.log(response.data);
                if(response.data =="Correcto"){
                    window.location.href="panel.php";
                }else if (response.data == "Incorrecto"){
                    this.incorrecto = 1;
                    setTimeout(()=>{
                        this.incorrecto = 0
                    },3000)
                }
            }).catch(error=>{
                console.log("Error :-("+error)
            }).finally(()=>{

            })
        }
    }
}

var mountedApp = Vue.createApp(app).mount('#app');
