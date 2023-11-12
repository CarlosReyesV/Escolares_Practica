<template>
    <div>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-between mb-4">
                    <a href="createStudent" class="text-center text-white hover:text-white bg-cyan-500 hover:bg-cyan-700 font-bold sm:p-3 p-2">
                        Agregar alumno
                    </a>
                    <div>
                        <button @click='getData' class="text-center sm:mt-0 mt-1 rounded-l-lg bg-cyan-500 hover:bg-cyan-700 border-2 border-cyan-500 hover:border-cyan-700 text-white hover:text-white font-bold sm:p-3 p-2">
                            Revertir
                        </button>
                        <input v-model="search" type="text" class="form-input border-2 border-gray-300 focus:ring-0 focus:border-cyan-500 focus:border-1 sm:p-3 p-2" onkeydown="return /[0-9]/i.test(event.key)" placeholder="Buscar ID..." @keyup.enter="searchStudent">
                    </div>
                </div>
                <div class="overflow-scroll surface-overlay">
                    <table>
                        <thead class="text-base">
                            <tr class="bg-gray-200 text-gray-600 uppercase leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Matricula</th>
                                <th class="py-3 px-6 text-left">Apellido Paterno</th>
                                <th class="py-3 px-6 text-left">Apellido Materno</th>
                                <th class="py-3 px-6 text-left">Nombre</th>
                                <th class="py-3 px-6 text-left"></th>
                                <th class="py-3 px-6 text-left"></th>
                            </tr>    
                        </thead>
                        <tbody class="text-gray-600 text-base font-light">
                            <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="(item, index) in apiData" :key="index">
                                <td class="border-b py-3 px-6">{{ item.id }}</td>
                                <td class="border-b py-3 px-6">{{ item.matricula }}</td>
                                <td class="border-b py-3 px-6">{{ item.paterno }}</td>
                                <td class="border-b py-3 px-6">{{ item.materno }}</td>
                                <td class="border-b py-3 px-6">{{ item.nombre }}</td>
                                <td class="px-4 py-2">
                                    <NavLink :href="'/editStudent/'+ item.id" class="text-yellow-400">
                                        Editar
                                    </NavLink>
                                </td>
                                <td class="px-4 py-2">
                                    <NavLink @click="deleteStudent(item.id)" class="text-red-500">
                                        Borrar
                                    </NavLink>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavLink from '@/Components/NavLink.vue';

export default {
    components: {
        NavLink
    },
    data() {
        return {
            search: null,
            apiData: [],
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        /* Get data */
        getData() {
            axios.get('/api/school').then(response => {
                    this.apiData = response.data.response;
                    //console.log(this.apiData);
                }).catch(errors => {
                    this.manageErrors(errors)
                })
        },
        /* Search */
        searchStudent(){
            if (this.search !== null) {
                axios.get('/api/school/searchbar/' + this.search)
                    .then(response => {
                        this.apiData = response.data;
                        //console.log(this.apiData);
                    })
                    .catch(error => {
                        console.error('Error al obtener datos: ', error);
                    });
            } else {
                console.error('ID es nulo');
            }
        },
        /* Delete */
        deleteStudent(id) {
        if (confirm('¿Seguro que deseas eliminar este registro?')) {
            axios.delete('/api/school/' + id).then(response => {
                    this.getData();
                })
                .catch(error => {
                    console.error('Error al eliminar el estudiante:', error);
                });
            }
        }
    }
};
</script>