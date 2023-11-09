<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar alumno
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <div class="md:col-span-2 mt-5 md:mt-0">
                            <div class="shadow bg-white md:rounded-md p-4">
                                <div class="flex justify-between text-gray-600">
                                    <h3 class="">Después de crear el registro, podrás editarlo y eliminarlo</h3>
                                    <NavLink :href="route('dashboard')" class="text-gr">Regresar</NavLink>
                                </div>
                                <hr class="my-4">
                                <form @submit.prevent="submit">
                                    <section class="grid grid-cols-3">
                                        <div class="mx-2">
                                            <InputLabel for="id" class="bold font-medium text-base text-gray-700">ID</InputLabel>
                                            <TextInput id="id" maxlength="18" v-model="form.id" required class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="mx-2">
                                            <InputLabel for="clave" class="bold font-medium text-base text-gray-700">Clave</InputLabel>
                                            <TextInput id="clave" maxlength="18" v-model="form.clave" required class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="mx-2">
                                            <InputLabel for="matricula" class="bold font-medium text-base text-gray-700 mx-2">Matrícula</InputLabel>
                                            <TextInput id="matricula" maxlength="20" v-model="form.matricula" required class="uppercase my-2 block w-full" />
                                        </div>
                                    </section>
                                    <section class="grid grid-cols-2">
                                        <div class="mx-2">
                                            <InputLabel for="paterno" class="bold font-medium text-base text-gray-700">Apellido Paterno</InputLabel>
                                            <TextInput id="paterno" maxlength="50" v-model="form.paterno" autocomplete="family-name" required class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="mx-2">
                                            <InputLabel for="materno" class="bold font-medium text-base text-gray-700 mx-2">Apellido Materno</InputLabel>
                                            <TextInput id="materno" maxlength="50" v-model="form.materno" autocomplete="family-name" class="uppercase my-2 block w-full" />
                                        </div>
                                    </section>
                                    <section class="grid grid-cols-2">
                                        <div class="mx-2">
                                            <InputLabel for="nombre" class="bold font-medium text-base text-gray-700">Nombre</InputLabel>
                                            <TextInput id="nombre" maxlength="50" v-model="form.nombre" autocomplete="name" required class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="justify-end grid content-end">
                                            <button class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold w-24 h-10 my-2 py-2 px-4">Registrar</button>
                                        </div>
                                    </section>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>  
        </div>            
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    components: {
        AppLayout,
        NavLink,
        InputLabel,
        TextInput
    },
    props: {
        item: Object,
        studentID: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            apiData: [],
            form: {
                id: '',
                clave: '',
                matricula: '',
                paterno: '',
                materno: '',
                nombre: '',
            }
        };
    },
    mounted() {
        this.getStudentData(this.studentID);
    },
    methods: {
        assignFormData(studentData) {
            this.form.id = studentData.id;
            this.form.clave = studentData.clave;
            this.form.matricula = studentData.matricula;
            this.form.paterno = studentData.paterno;
            this.form.materno = studentData.materno;
            this.form.nombre = studentData.nombre;
        },
        getStudentData(){
            axios.get('/api/school/searchbar/' + this.studentID).then(response => {
                this.apiData = response.data.response;
                this.assignFormData(this.apiData);
            }).catch(errors => {
                this.manageErrors(errors)
            })
        },
        submit() {
            const formData = {
                id: this.form.id,
                clave: this.form.clave.toUpperCase(),
                matricula: this.form.matricula.toUpperCase(),
                paterno: this.form.paterno.toUpperCase(),
                materno: this.form.materno.toUpperCase(),
                nombre: this.form.nombre.toUpperCase(),
            };
            axios.put('/api/school', formData).then(response => {
                    console.log('Alumno actualizado:', response.data);
                    window.location.href = '/dashboard';
                })
                .catch(error => {
                    console.error('Error al actualizar el alumno:', error);
                });
        },
    }
};
</script>