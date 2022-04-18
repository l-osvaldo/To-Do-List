<template>
    <div class="shadow-md p-4">
        <div class="">
            <div class="flex flex-col">
                <div class="grid grid-cols-1 w-56">
                    <div class="">
                        <label for="sortToDo">
                            Ordenar por:
                        </label>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <select class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full pl-10"
                                id="sortToDo"
                                v-model="selected"
                                @change="sortToDoMethod">
                                <option :value="0" disabled>Selecciona una opción...</option>
                                <option :value="1">Titulo ASC</option>                                
                                <option :value="2">Titulo DES</option>                                
                                <option :value="3">Descripción ASC</option>                                
                                <option :value="4">Descripción DES</option>                                
                                <option :value="5">Creado ASC</option>                                
                                <option :value="6">Creado DES</option>                                
                                <option :value="7">Editado ASC</option>                                
                                <option :value="8">Editado DES</option>                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['toDoList'],
    data(){
        return {
            selected: 0,
            filtro: null,
        }
    },
    methods:{
        sortToDoMethod() {
            if (this.selected != 0) {
                
                switch (this.selected) {
                    case '1':
                        this.filtro = this.toDoList.sort( (a, b) => {
                            if(a.titulo > b.titulo) return 1;
                            if(a.titulo < b.titulo) return -1;

                            return 0;
                        })
                        break            
                    case '2':
                        this.filtro = this.toDoList.sort( (a, b) => {
                            if(a.titulo < b.titulo) return 1;
                            if(a.titulo > b.titulo) return -1;

                            return 0;
                        })
                        break   
                    case '3':
                        this.filtro = this.toDoList.sort( (a, b) => {
                            if(a.descripcion > b.descripcion) return 1;
                            if(a.descripcion < b.descripcion) return -1;

                            return 0;
                        })
                        break           
                    case '4':
                        this.filtro = this.toDoList.sort( (a, b) => {
                            if(a.descripcion < b.descripcion) return 1;
                            if(a.descripcion > b.descripcion) return -1;

                            return 0;
                        })
                        break 
                    case '5':
                        this.filtro = this.toDoList.sort( (a, b) => {
                           
                            var dateA = this.formatDate(a.created_at)
                            var dateB = this.formatDate(b.created_at)
                            
                            if(dateA.getTime() > dateB.getTime()) return 1;
                            if(dateA.getTime() < dateB.getTime()) return -1;

                            return 0;
                        })
                        break  
                    case '6':
                        this.filtro = this.toDoList.sort( (a, b) => {
                           
                            var dateA = this.formatDate(a.created_at)
                            var dateB = this.formatDate(b.created_at)
                            
                            if(dateA.getTime() < dateB.getTime()) return 1;
                            if(dateA.getTime() > dateB.getTime()) return -1;

                            return 0;
                        })
                        break  
                    case '7':
                        this.filtro = this.toDoList.sort( (a, b) => {
                           
                            var dateA = this.formatDate(a.updated_at)
                            var dateB = this.formatDate(b.updated_at)
                            
                            if(dateA.getTime() > dateB.getTime()) return 1;
                            if(dateA.getTime() < dateB.getTime()) return -1;

                            return 0;
                        })
                        break  
                    case '8':
                        this.filtro = this.toDoList.sort( (a, b) => {
                           
                            var dateA = this.formatDate(a.updated_at)
                            var dateB = this.formatDate(b.updated_at)
                            
                            if(dateA.getTime() < dateB.getTime()) return 1;
                            if(dateA.getTime() > dateB.getTime()) return -1;

                            return 0;
                        })
                        break  
                }
            }
            this.$emit('sort', this.filtro);
        },
        formatDate(date){
            let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            // Descomponemos la cadena para obtener la fecha, tiene un formato "Miércoles, 13 de Abril del 2022 a las 03:22:17 p. m."
            var splitFecha = date.split(' ')
            var splitHora = splitFecha[8].split(':')
            
            // Formato de fecha para comparar
            return new Date(splitFecha[5], meses.indexOf(splitFecha[3]), splitFecha[1], splitHora[0], splitHora[1], splitHora[2])
        }
    }
}
</script>

