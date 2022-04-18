<template>
    <div class="shadow-md p-4">
        <div class="">
            <div class="flex flex-col">
                <div class="grid grid-cols-1 w-56">
                    <div class="">
                        <label for="search">
                            Buscar:
                        </label>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <span class="z-10 h-full leading-snug font-normal absolute text-center text-slate-300 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input 
                                id="search" 
                                @keyup="filter"
                                v-model="value"
                                type="text" 
                                placeholder="Buscar" 
                                class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full pl-10"/>
                        </div>
                        <small v-if="coincidence" class="text-red-600">*No existen coincidencias</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['toDoList','input'],
    data(){
        return{
            value: this.input,
            filtro: this.toDoList,
            coincidence: false
        }
    },
    methods: {
        filter(){
            if (this.value != '') {
                this.filtro = this.toDoList.filter( toDO => 
                    toDO.titulo.includes(this.value)        ||
                    toDO.descripcion.includes(this.value)   ||
                    toDO.created_at.includes(this.value)    ||
                    toDO.updated_at.includes(this.value))  
                this.coincidence = this.filtro.length > 0 ? false : true            
            }else{
                this.coincidence = false
                this.filtro = this.toDoList
            }
            this.$emit('search', this.filtro);
        }
    }
}
</script>
