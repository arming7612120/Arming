
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
                        <i class="fa fa-align-justify"></i> Institutos Militares
                        <button type="button" @click="abrirModal('instituto', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                        <option value="sigla">Sigla</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarInstituto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarInstituto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Instituto Militar</th>
                                    <th>Sigla</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="instituto in arrayInstituto" :key="instituto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('instituto','actualizar', instituto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                       <template v-if="instituto.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarInstituto(instituto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarInstituto(instituto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                        <td v-text="instituto.nombre"></td>
                                        <td v-text="instituto.sigla"></td>
                                    <td>
                                        <div v-if="instituto.condicion">
                                        <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
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
                                <!--   Nombre de Instituto-->
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Instituto Militar</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Instituto Militar">
                                        </div>
                                </div>
                                <!--  Sigla de Instituto-->
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Sigla Inst. Militar</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="sigla" class="form-control" placeholder="Sigla">                                       
                                        </div>
                                </div>
                            </form>
                        </div>
                         <!-- FIN DE LA VENTANA MODAL-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary"  @click="registrarInstituto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary"  @click="actualizarInstituto()">Actualizar</button>
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
                instituto_id : 0,
                nombre : '',
                sigla :'',
                arrayInstituto :[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorInstituto : 0,
                errorMostrarMsjInstituto : [],
                pagination : {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                    },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
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
            listarInstituto (page,buscar,criterio){
                let me = this;
                var url = '/instituto?page=' + page +'&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayInstituto = respuesta.institutos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualizar la pagina actual
                me.pagination.current_page = page;
                //Enviar la peticion par visualizar la data de esta pagina
                me.listarInstituto(page,buscar,criterio);
            },
            registrarInstituto(){
                if(this.validarInstituto()){
                    return;
                }
                let me=this;

                axios.post('/instituto/registrar', {
                    'nombre': this.nombre,
                    'sigla': this.sigla,
                }).then(function (response) {
                me.cerrarModal();
                me.listarInstituto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });  
            },
            actualizarInstituto(){
                if(this.validarInstituto()){
                    return;
                }

                let me=this;

                axios.put('/instituto/actualizar', {
                    'nombre': this.nombre,
                    'sigla': this.sigla,
                    'id' : this.instituto_id
                }).then(function (response) {
                me.cerrarModal();
                me.listarInstituto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });   
            },
            desactivarInstituto(id){
                swal({
                title: 'Esta seguro de desactivar a este Instituto Militar???',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;

                    axios.put('/instituto/desactivar', {

                        'id' : id
                    }).then(function (response) {
                    me.listarInstituto(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                   
                }
                })

            },
            activarInstituto(id){
                swal({
                title: 'Esta seguro de activar a este Instituto Militar????',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;

                    axios.put('/instituto/activar', {

                        'id' : id
                    }).then(function (response) {
                    me.listarInstituto(1,'','nombre');
                    swal(
                        'Activado',
                        'El registro ha sido activado con exíto.',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                   
                }
                })

            },
            validarInstituto(){
                this.errorInstituto = 0;
                this.errorMostrarMsjInstituto = [];

                if(!this.nombre) this.errorMostrarMsjInstituto.push("El campo nombre del Instituto es requerido!!");
                if(!this.sigla) this.errorMostrarMsjInstituto.push("El campo Sigla es un campo requerido.!!");
                if(this.errorMostrarMsjInstituto.length) this.errorInstituto = 1;
                return this.errorInstituto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.sigla='';
                this.errorInstituto=0; 
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "instituto":
                    {
                        switch(accion){
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Nueva Instituto';
                                    this.nombre='';
                                    this.sigla='';
                                    this.tipoAccion = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                   // console.log(data);
                                    this.modal=1;
                                    this.tituloModal='Actualizar Datos del Instituto';
                                    this.tipoAccion=2;
                                    this.instituto_id = data['id'];
                                    this.nombre = data['nombre'];
                                    this.sigla = data['sigla'];                                  
                                    break;
                                }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarInstituto(1,this.buscar,this.criterio);
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

