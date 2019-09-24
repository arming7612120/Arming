
<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Personas
                        <button type="button" @click="abrirModal('persona', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="ci">C.I.</option>
                                        <option value="paterno">Ap. Paterno</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Ap. Paterno</th>
                                    <th>Ap. Materno</th>
                                    <th>Nombres</th>
                                    <th>C.I.</th>
                                    <th>Exp.</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar', persona)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                       <template v-if="persona.idtipo">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPersona(persona.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarPersona(persona.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                        <td v-text="persona.paterno"></td>
                                        <td v-text="persona.materno"></td>
                                        <td v-text="persona.nombre"></td>
                                        <td v-text="persona.ci"></td>
                                        <td v-text="persona.expedido"></td>
                                    <td>
                                        <div v-if="persona.idtipo">
                                            <span class="badge badge-success">Nuevo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Baja</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' :'']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page">1</a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <!--   INICIO DE LA VENTANA MODAL-->

                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"> 
                                <!--   Apellido Paterno-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Apellido Paterno</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="paterno" class="form-control" placeholder="Apellido Paterno">
                                        </div>
                                </div>
                                <!--  Apellido Materno-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Apellido Materno</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="materno" class="form-control" placeholder="Apellido Materno">
                                        </div>
                                </div>
                                <!--  Nombre-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Nombres</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombres">
                                        </div>
                                </div>
                                <!--  Cédula de Identidad-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Cédula de Identidad</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="ci" class="form-control" placeholder="Cédula de Identidad">
                                        </div>
                                </div>
                                <!--  Expedido-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Expedido en</label>
                                        <div class="col-md-4">
                                             <select class="form-control" v-model="expedido" placeholder="Seleccione">
                                                <option value="LP">La Paz</option>
                                                <option value="CB">Cochabamba</option>
                                                <option value="SC">Santa Cruz</option>
                                                <option value="PT">Potosí</option>
                                                <option value="OR">Oruro</option>
                                                <option value="CH">Chuquisaca</option>
                                                <option value="BN">Beni</option>
                                                <option value="PN">Pando</option>
                                                <option value="TJ">Tarija</option>  
                                            </select>
                                        </div>
                                </div>
                                <!--  Tipo y Descripción-->
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="text-input">Tipo</label>
                                        <div class="col-md-4">
                                            <select class="form-control" v-model="idtipo">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="tipo in arrayTipo" :key="tipo.id" :value="tipo.id"  v-text="tipo.registrado"></option>
                                            </select>                                   
                                        </div>
                                </div>
                                <div v-show="errorPersona" class="form-group-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                         <!-- FIN DE LA VENTANA MODAL-->
                        <div class="modal-footer">
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary"  @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary"  @click="actualizarPersona()">Actualizar</button>
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data() {
            return {
                persona_id : 0,
                paterno : '',
                materno : '',
                nombre : '',
                ci :'',
                expedido : 'LP',
                idtipo : 0,
                registrado : '',
                arrayPersona :[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                    },
                offset : 3,
                criterio : 'ci',
                buscar : '',
                arrayTipo : []
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                } 
                return pagesArray;
            }
        },
        methods: {
            listarPersona (page,buscar,criterio){
                let me = this;
                var url = '/persona?page=' + page +'&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectTipo(){
                let me=this;
                var url = '/tipos/selectTipo';
                axios.get(url).then(function (response) {
                 var respuesta = response.data;
                 me.arrayTipo = respuesta.tipos;   
                })
                .catch(function (error){
                    console.log(error);
                });
            }, 
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualizar la pagina actual
                me.pagination.current_page = page;
                //Enviar la peticion par visualizar la data de esta pagina
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){
                if(this.validarPersona()){
                    return;
                }
                let me=this;

                axios.post('/persona/registrar', {
                    'paterno': this.paterno,
                    'materno': this.materno,
                    'nombre': this.nombre,
                    'ci': this.ci,
                    'expedido': this.expedido,
                    'idtipo': this.idtipo,
                }).then(function (response) {
                me.cerrarModal();
                me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });  
            },
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                let me=this;
                console.log(this.persona_id);
                axios.put('/persona/actualizar', {
                    'paterno': this.paterno,
                    'materno': this.materno,
                    'nombre': this.nombre,
                    'ci': this.ci,
                    'expedido': this.expedido,
                    'idtipo': this.idtipo,
                    'id' : this.persona_id
                }).then(function (response) {
                me.cerrarModal();
                me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });   
            },    
            validarPersona(){
                this.errorPersona = 0;
                this.errorMostrarMsjPersona = [];
                if(!this.nombre) this.errorMostrarMsjPersona.push("El campo nombre es requerido!!");
                if(!this.ci) this.errorMostrarMsjPersona.push("El campo Cédula de identidad es requerido!!");
                if(this.errorMostrarMsjPersona.length) this.errorPersona = 1;
                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.paterno='';
                this.materno='';
                this.nombre='';
                this.ci='';
                this.expedido='';
                this.idtipo=0;
                this.registrado='';
                this.errorPersona=0; 
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Persona';
                                    this.paterno='';
                                    this.materno='';
                                    this.nombre='';
                                    this.ci='';
                                    this.expedido='';
                                    this.idtipo=0;
                                    this.registrado=0;
                                    this.tipoAccion = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    console.log(data);
                                    this.modal=1;
                                    this.tituloModal='Actualizar Datos de Persona';
                                    this.tipoAccion=2;
                                    this.persona_id = data['id'];
                                    this.idtipo = data['idtipo']; 
                                    this.paterno = data['paterno'];
                                    this.materno = data['materno'];
                                    this.nombre = data['nombre'];
                                    this.ci = data['ci'];
                                    this.expedido = data['expedido'];                              
                                    break;
                                }
                        }
                    }
                }
                this.selectTipo();
            }
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;

    }
</style>

