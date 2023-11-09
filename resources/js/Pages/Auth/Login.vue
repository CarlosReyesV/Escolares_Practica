<template>
    <Head title="Log in" />
    <AuthenticationCard class="justify-center">
        <!-- <template #logo></template> -->
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">Iniciar sesión</h1>
        <form @submit.prevent="submit">
            <div class="mb-6">
                <InputLabel for="email" value="Correo Electrónico" class="block mb-2 text-sm text-gray-600"/>
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full px-4 py-2 border"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" class="block mb-2 text-sm text-gray-600"/>
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="w-full px-4 py-2 borde"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" class=""/>
                    <span class="ms-2 text-sm text-gray-600 focus:ring-2 focus:ring-cyan-500">Recordarme</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-cyan-900 hover:text-cyan-500 rounded-md">
                    ¿Olvidaste tu contraseña?
                </Link>
                <PrimaryButton class="ms-4 text-white" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Accesar
                </PrimaryButton>
            </div>
            <div class="text-center mt-5">
                <p class="text-sm">¿No tienes una cuenta? <Link :href="route('register')" class="text-cyan-500 hover:text-cyan-900">Regístrate ahora</Link></p>
            </div>
        </form>
    </AuthenticationCard>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>