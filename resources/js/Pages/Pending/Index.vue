<template>
    <AppLayout title="Pendientes">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pendientes
            </h2>
        </template>

        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-6">
                        <div class="col-end-7 col-span-1">
                            <button @click="openRegister" class="px-4 py-2 my-3 font-bold text-white bg-green-500 rounded  hover:bg-green-700">
                                <i class="fas fa-plus"></i>
                                Agregar Tarea
                            </button>
                        </div>                        
                    </div>
                    <table class="w-full table-fixed">
                        <tbody>
                            <tr v-for="row in toDoList" :key="row" class="border">
                                <td class="p-4 w-4/5">
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
                                <td class="p-4 w-1/5">
                                    <div class="grid grid-cols-3">
                                        <div class="m-2">
                                            <button @click="deleteToDo(row)">
                                                <i class="fas fa-trash fa-2x text-red-600 hover:text-black"></i>
                                            </button>
                                        </div>
                                        <div class="m-2">
                                            <button @click="openEditarModal(row)">
                                                <i class="fas fa-pen fa-2x text-blue-600 hover:text-black"></i>
                                            </button>
                                        </div>
                                        <div class="m-2">
                                            <button @click="complete(row.id)">
                                                <i class="fas fa-check fa-2x text-green-600 hover:text-black"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <RegisterAndEditModal v-if="isOpenRegisterEditModal" 
                        :title="title" 
                        :toDoList="form"
                        @cerrar="closeModal"
                        :isMode="isMode">
                        
                        <template v-slot:btn_cerrar>
                            <button
                                @click="closeModal"
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm  hover:text-white focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5 hover:bg-red-500"
                            >
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
import RegisterAndEditModal from '../Pending/Partials/RegisterAndEditModal'

export default {
    components: {
        AppLayout,
        RegisterAndEditModal
    },
    props: ["toDoList"],
    data(){
        return {
            title: null,
            isOpenRegisterEditModal: false,
            isMode: false,
            form: {
                id: null,
                titulo: null,
                descripcion: null,
            },
        }
    },
    methods: {
        openRegister() {
            this.resetForm() 
            this.isOpenRegisterEditModal = true
            this.title = "Agregar Tarea"
            this.isMode = false;
        },
        openEditarModal(toDoList){
            this.isOpenRegisterEditModal = true
            this.isOpenDetailModal = false
            this.isMode = true
            this.form = Object.assign({}, toDoList)
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
                titulo: null,
                descripcion: null,
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
        }
    },
}
</script>
