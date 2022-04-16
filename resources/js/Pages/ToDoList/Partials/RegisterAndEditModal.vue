<template>
    <div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center  sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl  sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline">
                <div class="container mx-auto">
                    <div class="h-12 bg-green-500 bg-opacity-75 p-2.5">
                        <jet-label class="text-2xl text-white" for="Registrar" :value="title" />
                    </div>
                    <div class="p-2.5">
                        <form>

                            <div class="mb-4">
                                <label
                                    for="registerEditTitulo"
                                    class="block mb-2 text-sm font-bold text-gray-700" >
                                    Titulo:
                                </label>
                                <input
                                    type="text"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
                                    id="registerEditTitulo"
                                    placeholder="Titulo"
                                    @keyup="changeTitulo"
                                    v-model="form.titulo"/>  
                                    <div v-if="isShowValidateTitle" class="text-red-500">
                                        <label for="registerEditTitulo">
                                            *El campo Titulo es obligatorio
                                        </label>
                                    </div>                              
                            </div>
                            <div class="mb-4">
                                <label
                                    for="registerEditDescripcion"
                                    class="block mb-2 text-sm font-bold text-gray-700" >
                                    Descripción:
                                </label>
                                <input
                                    type="text"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
                                    id="registerEditDescripcion"
                                    placeholder="Descripción"
                                    @keyup="changeDescripcion"
                                    v-model="form.descripcion"/>
                                    <div v-if="isShowValidateDescription" class="text-red-500">
                                        <label for="registerEditTitulo">
                                            *El campo Descripción es obligatorio
                                        </label>
                                    </div>                                 
                            </div>
                        </form>
                        <hr>
                        <div class="mt-5 flex space-x-4 justify-end">
                            <div>
                                <slot name="btn_cerrar"></slot>
                            </div>
                            <button
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md shadow-sm  hover:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5"
                                v-if="!isMode"
                                @click="save(form)"
                            >
                                Registrar
                            </button>
                            <button
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md shadow-sm  hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5"
                                v-if="isMode"
                                @click="update(form)"
                            >
                                Actualizar
                            </button>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetLabel from '@/Jetstream/Label.vue'
export default {
    props: ['title','isMode','toDoList'],
    components: {
        JetLabel
    },
    data(){
        return{
            form: this.$inertia.form({
                _method: 'POST',
                id: this.toDoList.id,
                titulo: this.toDoList.titulo,
                descripcion: this.toDoList.descripcion,
            }),
            isShowValidateTitle: false,
            isShowValidateDescription: false,
        }
    },
    methods:{
        save(data) {
            if (this.validateInputs()) {
                this.$inertia.post("/pending", data , {
                    onFinish: visit => {
                        this.$swal({
                            icon: 'success',
                            title: 'To Do',
                            text: 'Creado Exitosamente',
                            confirmButtonColor: '#008000',
                        })
                        this.$emit("cerrar")
                    },
                })                  
            }
        },
        update(data){
            if (this.validateInputs()) {
                data._method = "PUT";
                this.$inertia.post("pending/" + data.id, data , {
                    onFinish: visit => {
                        this.$swal({
                            icon: 'success',
                            title: 'To Do',
                            text: 'Actualizado Exitosamente',
                            confirmButtonColor: '#008000',
                        })
                        this.$emit("cerrar")
                    }
                })                
            }
        },
        validateInputs(){
            if (this.form.titulo === null || this.form.titulo === '') {
                this.isShowValidateTitle = true
                return false
            }
            if (this.form.descripcion === null || this.form.descripcion === '') {
                this.isShowValidateDescription = true
                return false
            }
            return true
        },
        changeTitulo(){
            this.isShowValidateTitle = this.form.titulo === null || this.form.titulo === '' ? true : false;            
        },
        changeDescripcion(){
            this.isShowValidateDescription = this.form.descripcion === null || this.form.descripcion === '' ? true : false;            
        }
    },
}
</script>
