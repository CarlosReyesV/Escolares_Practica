<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Agregar alumno
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
                                    <section class="grid grid-cols-2">
                                        <div class="mx-2">
                                            <InputLabel for="clave" class="bold font-medium text-base text-gray-700">Clave
                                            </InputLabel>
                                            <TextInput id="clave" type="text" minlength="18" maxlength="18"
                                                v-model="form.clave" onkeydown="return /[a-zA-Z0-9]/i.test(event.key)"
                                                class="uppercase my-2 block w-full" @input="updateMatricula" />
                                        </div>
                                        <div class="mx-2">
                                            <InputLabel for="matricula"
                                                class="bold font-medium text-base text-gray-700 mx-2">Matrícula</InputLabel>
                                            <TextInput id="matricula" type="text" minlength="20" maxlength="20"
                                                v-model="form.matricula" class="uppercase my-2 block w-full" />
                                        </div>
                                    </section>
                                    <section class="grid grid-cols-2">
                                        <div class="mx-2">
                                            <InputLabel for="paterno" class="bold font-medium text-base text-gray-700">
                                                Apellido Paterno</InputLabel>
                                            <TextInput id="paterno" type="text" minlength="2" maxlength="50"
                                                v-model="form.paterno" onkeydown="return /[a-zA-Z]/i.test(event.key)"
                                                autocomplete="family-name" class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="mx-2">
                                            <InputLabel for="materno" class="bold font-medium text-base text-gray-700 mx-2">
                                                Apellido Materno</InputLabel>
                                            <TextInput id="materno" type="text" minlength="2" maxlength="50"
                                                v-model="form.materno" onkeydown="return /[a-zA-Z]/i.test(event.key)"
                                                autocomplete="family-name" class="uppercase my-2 block w-full" />
                                        </div>
                                    </section>
                                    <section class="grid grid-cols-2">
                                        <div class="mx-2">
                                            <InputLabel for="nombre" class="bold font-medium text-base text-gray-700">Nombre
                                            </InputLabel>
                                            <TextInput id="nombre" type="text" minlength="2" maxlength="50"
                                                v-model="form.nombre" 
                                                autocomplete="name" class="uppercase my-2 block w-full" />
                                        </div>
                                        <div class="justify-end grid content-end">
                                            <button :disabled="!isFormComplete"
                                                :class="{ 'bg-cyan-500 hover:bg-cyan-700 text-white font-bold w-24 h-10 my-2 py-2 px-4': true, 'hover:bg-cyan-500 cursor-not-allowed opacity-50': !isFormComplete }">Registrar</button>
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
    data() {
        return {
            form: {
                clave: '',
                matricula: '',
                paterno: '',
                materno: '',
                nombre: '',
            },
            isFormComplete: false,
            isClaveValid: true,
        }
    },
    // Check if form is completed
    watch: {
        'form.clave': 'updateFormCompleteState',
        'form.matricula': 'updateFormCompleteState',
        'form.paterno': 'updateFormCompleteState',
        'form.materno': 'updateFormCompleteState',
        'form.nombre': 'updateFormCompleteState',
    },
    methods: {
        // Create data
        submit() {
            const formData = {
                clave: this.form.clave.toUpperCase(),
                matricula: this.form.matricula.toUpperCase(),
                paterno: this.form.paterno.toUpperCase(),
                materno: this.form.materno.toUpperCase(),
                nombre: this.form.nombre.toUpperCase(),
            };
            try {
                this.validateClave();
                this.validateNames();
                this.validateForm();
                if (confirm('¿Seguro que deseas crear este registro?')) {
                    axios.post('/api/school', formData).then(response => {
                        alert('Alumno agregado', response.data);
                        window.location.href = '/dashboard';
                    }).catch(error => {
                        console.error('Error al actualizar el alumno:', error);
                    });
                }
            } catch (error) {
                alert(error.message);
            }
        },
        // Fill field
        updateMatricula() {
            const clave = this.form.clave;
            if (clave.length === 18) {
                const matricula = `${clave.slice(0, 4)}-${clave.slice(4, 16)}-${clave.slice(16)}`;
                this.form.matricula = matricula.toUpperCase();
            }
            else {
                this.form.matricula = '';
            }
        },
        // Validate input data
        validateClave() {
            const clavePattern = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
            ///^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
            if (!clavePattern.test(this.form.clave)) {
                throw new Error('La clave es incorrecta, debe tener el formato CURP');
            }
            // Validate
            const curpApellidosNombre = this.form.clave.substring(0, 4);
            const apellidoPaterno = this.form.paterno.substring(0, 2);
            const apellidoMaterno = this.form.materno.substring(0, 1);
            const nombre = this.form.nombre.substring(0, 1);

            if (curpApellidosNombre !== (apellidoPaterno + apellidoMaterno + nombre)) {
                throw new Error('Las primeras letras de la CURP no coinciden con los apellidos y el nombre.');
            }
        },
        validateNames() {
            // No blank spaces
            this.form.paterno = this.form.paterno.trim();
            this.form.materno = this.form.materno.trim();
            this.form.nombre = this.form.nombre.trim();
            // One blank space by name
            this.form.nombre = this.form.nombre.replace(/\s+/g, ' ');
            // Only letters and one blank space by name
            this.form.nombre = this.form.nombre.replace(/[^a-zA-Z ]/g, '');
        },
        // Check if form is valid
        validateForm() {
            if (!this.form.clave) throw new Error("Falta la clave");
            if (!this.form.matricula) throw new Error("Falta la matricula");
            if (!this.form.paterno) throw new Error("Falta el apellido paterno");
            if (!this.form.materno) throw new Error("Falta el apellido materno");
            if (!this.form.nombre) throw new Error("Falta el nombre");
            // Validates length
            if (this.form.clave.length < 18) throw new Error("La clave debe tener al menos 18 caracteres");
            if (this.form.matricula.length < 20) throw new Error("La matricula debe tener al menos 18 caracteres");
            if (this.form.paterno.length < 2) throw new Error("El apellido paterno debe tener al menos 2 caracteres");
            if (this.form.materno.length < 2) throw new Error("El apellido materno debe tener al menos 2 caracteres");
            if (this.form.nombre.length < 2) throw new Error("El nombre debe tener al menos 2 caracteres");
        },
        updateFormCompleteState() {
            this.isFormComplete =
                this.form.clave &&
                this.form.matricula &&
                this.form.paterno &&
                this.form.materno &&
                this.form.nombre;
        },
    }
}
</script>