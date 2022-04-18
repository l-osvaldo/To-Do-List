<template>
    <AppLayout :title="title">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pendientes
            </h2>
        </template>
        <div class="m-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-center">
                <div class="md:w-11/12">
                    <div class="flex md:flex-row space-x-8">
                        <Search :toDoList="data" @search="search" :key="data" />
                        
                        <Sort :toDoList="data" @sort="sort" :key="data" />
                    </div>
                </div>
            </div>
        </div> 
        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-6">
                        <div class="col-end-7 col-span-1">
                            <button v-if="type" @click="openRegister" class="px-4 py-2 my-3 font-bold text-white bg-green-500 rounded  hover:bg-green-700">
                                <i class="fas fa-plus"></i>
                                Agregar Tarea
                            </button>
                            <button v-else-if="data.length != 0" @click="deleteAll" class="px-4 py-2 my-3 font-bold text-white bg-red-500 rounded  hover:bg-red-700">
                                <i class="fas fa-globe"></i>
                                Borrar Todo
                            </button>
                        </div>                        
                    </div>
                    <div v-if="data.length == 0" class="grid justify-items-center">
                        <p class="text-2xl text-red-500">
                            No existen tareas
                        </p>
                    </div>
                    <table class="w-full table-fixed">
                        <tbody>
                            <tr v-for="row in toDo" :key="row" class="border">
                                
                                <td class="p-2 w-4/5">
                                    <div class="grid grid-rows-3">
                                        <div class="m-0 p-0">
                                            <p class="font-bold text-2xl">
                                                {{ row.titulo }}
                                            </p>
                                        </div>
                                        <div class="m-0 p-0">
                                            <p class="text-sm">
                                                {{ row.descripcion }}
                                            </p>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <p>
                                                Creado: {{ row.created_at }}
                                            </p>
                                            <p>
                                                Editado: {{ row.updated_at }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 w-1/5">
                                    <div class="flex flex-row-reverse">
                                        <div class="m-5" v-if="type">
                                            <button @click="complete(row.id)">
                                                <i class="fas fa-check fa-2x text-green-600 hover:text-black"></i>
                                            </button>
                                        </div>                                        
                                        <div class="m-5" v-if="type">
                                            <button @click="openEditarModal(row)">
                                                <i class="fas fa-pen fa-2x text-blue-600 hover:text-black"></i>
                                            </button>
                                        </div>
                                        <div class="m-5">
                                            <button @click="deleteToDo(row)">
                                                <i class="fas fa-trash fa-2x text-red-600 hover:text-black"></i>
                                            </button>
                                        </div>                                        
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-if="toDo.length > 0" class="grid grid-cols-2">
                        <div>
                            <p class="m-2 font-bold">
                                {{ numPage }} de {{ totalPage }} páginas, total de tareas: {{ totalTarea }}
                            </p>
                        </div>
                        <div class="grid justify-items-end">
                            <div>
                                <button 
                                    @click="pageStart" 
                                    class="text-center items-center justify-center m-2"
                                    :class="[ activeStartPage ? 'hover:text-blue-600' : 'hover:text-gray-500']" 
                                    :disabled="!activeStartPage" title="Primera página">
                                    <i class="fas fa-angle-double-left fa-2x"></i>
                                </button>
                                <button 
                                    @click="previousPage"
                                    class="text-center items-center justify-center m-2" 
                                    :class="[ activePreviousPage ? 'hover:text-blue-600' : 'hover:text-gray-500']" 
                                    :disabled="!activePreviousPage" title="Página anterior">
                                    <i class="fas fa-angle-left fa-2x"></i>
                                </button>
                                <button class="m-2 font-bold" disabled>
                                    {{ numPage }}
                                </button>
                                <button 
                                    @click="nextPage"
                                    class="text-center items-center justify-center m-2" 
                                    :class="[activeNextPage ? 'hover:text-blue-600' : 'hover:text-gray-500']"
                                    :disabled="!activeNextPage" title="Página siguiente">
                                    <i class="fas fa-angle-right fa-2x"></i>
                                </button>
                                <button 
                                    @click="pageEnd" 
                                    class="text-center items-center justify-center m-2" 
                                    :class="[activeEndPage ? 'hover:text-blue-600' : 'hover:text-gray-500']"
                                    :disabled="!activeEndPage" title="Última página">
                                    <i class="fas fa-angle-double-right fa-2x"></i>
                                </button>

                            </div>
                        </div>        
                    </div>

                    <RegisterAndEditModal v-if="isOpenRegisterEditModal" 
                        :title="title" 
                        :toDoList="form"
                        @cerrar="closeModal"
                        :isMode="isMode">
                        
                        <template v-slot:btn_cerrar>
                            <button
                                @click="closeModal"
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm  hover:text-white focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5 hover:bg-red-500">
                                Cancelar
                            </button>
                        </template>
                    </RegisterAndEditModal>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import RegisterAndEditModal from '../ToDoList/Partials/RegisterAndEditModal'
import Search from '../ToDoList/Partials/Search'
import Sort from '../ToDoList/Partials/Sort'

export default {
    components: {
        AppLayout,
        RegisterAndEditModal,
        Search,
        Sort
    },
    props: ["data","type"],
    data(){
        return {
            title: null,
            isOpenRegisterEditModal: false,
            title: this.type ? 'Pendientes' : 'Completadas',
            isMode: false,
            form: {
                id: null,
                user_id: null,
                titulo: null,
                descripcion: null,
                status: null,
                created_at: null,
                updated_at: null
            },
            toDo: this.data,
            numPage: 1,
            totalPage: this.data.length % 5 == 0 ? this.data.length / 5 : Math.trunc(this.data.length / 5) + 1,
            totalTarea: this.data.length,
            activeStartPage: false,
            activeNextPage: false,
            activePreviousPage: false,
            activeEndPage: false,
        }
    },
    methods: {
        openRegister() {
            this.resetForm() 
            this.isOpenRegisterEditModal = true
            this.title = "Agregar Tarea"
            this.isMode = false;
        },
        openEditarModal(data){
            this.isOpenRegisterEditModal = true
            this.isOpenDetailModal = false
            this.isMode = true
            this.form = Object.assign({}, data)
            this.title = "Editar Información de la Tarea"
        },
        closeModal() {
            this.isOpenRegisterEditModal = false
            this.title = ""
            this.resetForm()           
        },
        resetForm(){
            this.form = {
                id: null,
                user_id: null,
                titulo: null,
                descripcion: null,
                status: null,
                created_at: null,
                updated_at: null
            }
        },
        complete(id){
            this.$swal({
                icon: 'question',
                title: 'To Do Complete',
                text: '¿Tarea Completada?',
                confirmButtonColor: '#008000',
                showCancelButton: true,
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post("pending/complete", {'id' : id}, {
                        onFinish: visit => {
                            this.activeBtnPagination()
                            this.$swal({
                                icon: 'success',
                                title: 'To Do',
                                text: 'To Do Complete',
                                confirmButtonColor: '#008000',
                            })
                        }
                    })
                }
            })
        },
        deleteToDo(data){
            this.$swal({
                icon: 'question',
                title: 'To Do Delete',
                text: '¿Eliminar Tarea Pendiente?',
                confirmButtonColor: '#008000',
                showCancelButton: true,
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    data._method = "DELETE"
                    this.$inertia.post("pending/" + data.id, data, {
                        onFinish: visit => {
                            this.activeBtnPagination()
                            this.$swal({
                                icon: 'success',
                                title: 'To Do',
                                text: 'To Do Delete',
                                confirmButtonColor: '#008000',
                            })
                        }
                    })
                }
            })
        },
        deleteAll(){
            this.$swal({
                icon: 'warning',
                title: 'To Do Complete',
                text: '¿Eliminar Todas las Tareas Completadas?',
                confirmButtonColor: '#008000',
                showCancelButton: true,
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post("complete/deleteAll", {
                        onFinish: visit => {
                            this.$swal({
                                icon: 'success',
                                title: 'To Do',
                                text: 'To Do Complete',
                                confirmButtonColor: '#008000',
                            })
                        }
                    })
                }
            })
        },
        calcularTotales(){
            this.totalPage = this.toDo.length % 5 == 0 ? this.toDo.length / 5 : Math.trunc(this.toDo.length / 5) + 1
            this.totalTarea = this.toDo.length
        },
        activeBtnPagination(){
            this.activeStartPage = this.numPage > 1 ? true:false
            this.activePreviousPage = this.numPage > 1 ? true : false,
            this.activeNextPage = this.totalPage > this.numPage && this.totalPage > 1 ? true:false,
            this.activeEndPage = this.numPage != this.totalPage && this.totalPage > 1 ? true:false
        },
        search(filtro){    
            this.toDo = filtro        
            if (filtro.length == this.data.length) this.range(1)  
            
            this.calcularTotales()  
            this.activeBtnPagination()       
        },
        sort(filtro){
            this.toDo = filtro
            this.numPage = 1
            this.calcularTotales()
            this.activeBtnPagination()
            this.range(1)
        },
        range(page){
            var start = (page * 5) - 5
            var end = (page * 5) - 1
            var index = 0

            this.toDo = this.data.filter( toDo =>  {
                var bandera = false
                if ( index >= start && index <= end ){
                    bandera = true
                } 
                index++
                return bandera
            })
        },
        pageStart(){
            this.numPage = 1
            this.activeBtnPagination()
            this.range(1)
        },
        pageEnd(){
            this.numPage = this.totalPage
            this.activeBtnPagination()
            this.range(this.totalPage)
        },
        nextPage(){
            this.numPage++
            this.activeBtnPagination()
            this.range(this.numPage)
        },
        previousPage(){
            this.numPage--
            this.activeBtnPagination()
            this.range(this.numPage)
        }
    },
    watch: {
        data() {
            this.toDo =  this.data
            this.numPage = 1
            this.calcularTotales()            
            this.activeBtnPagination() 
            this.range(1)
        },
    },
    created(){
        this.range(1)
        this.activeBtnPagination()
        
    },
}
</script>
