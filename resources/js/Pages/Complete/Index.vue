<template>
    <AppLayout title="Completas">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Completas
            </h2>
        </template>

        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-6">
                        <div class="col-end-7 col-span-1">
                            <button @click="deleteAll" class="px-4 py-2 my-3 font-bold text-white bg-red-500 rounded  hover:bg-red-700">
                                <i class="fas fa-globe"></i>
                                Borrar Todo
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
                                        <div class="m-2 col-end-4 col-span-1">
                                            <button @click="deleteToDo(row)">
                                                <i class="fas fa-trash fa-2x text-red-600 hover:text-black"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"

export default {
    components: {
        AppLayout,
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
        deleteToDo(data){
            this.$swal({
                icon: 'question',
                title: 'To Do Delete',
                text: '¿Eliminar Tarea Completada?',
                confirmButtonColor: '#008000',
                showCancelButton: true,
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    data._method = "DELETE"
                    this.$inertia.post("complete/" + data.id, data, {
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