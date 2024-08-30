<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect';

defineProps({
    roles: Array,
    permissions: Array,
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [],
    permissions: [],
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Crear Usuario" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Crear Nuevo Usuario</h1>
                        <Link :href="route('users.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class="mt-6 mx-5 mb-5 bg-slate-600 p-2 rounded-md">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Nombre de Usuario" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Correo Electrónico" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Contraseña" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                            <div class="container">
                                <div class="row flex">
                                    <div class="mt-3 w-1/3 mx-3">
                                        <InputLabel class="dark:text-slate-900" value="Roles" />
                                        <VueMultiselect class=" dark:border-slate-950 z-50"
                                            v-model="form.roles"
                                            :options="roles"
                                            :multiple="true"
                                            :close-on-select="true"
                                            placeholder="Elija los roles a asignar"
                                            label="name"
                                            track-by="id"
                                        />
                                    </div>
                                    <div class="mt-3 w-1/3 mx-3">
                                        <InputLabel class="dark:text-slate-900" value="Permisos" />
                                        <VueMultiselect class=" dark:border-slate-950 z-50"
                                            v-model="form.permissions"
                                            :options="permissions"
                                            :multiple="true"
                                            :close-on-select="true"
                                            placeholder="Elija los permisos a asignar"
                                            label="name"
                                            track-by="id"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Crear
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
