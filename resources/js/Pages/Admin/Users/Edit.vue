<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import { onMounted, watch } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: Array,
    permissions: Array,
});

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    //password: '',
    //password_confirmation: '',
    roles: [],
    permissions: [],
});

const submit = () => {
    form.put(route('users.update', props.user?.id),
        //{onFinish: () => form.reset('password', 'password_confirmation'),}
    );
};

onMounted(() =>{
    form.permissions = props.user?.permissions;
    form.roles = props.user?.roles;
});

watch(
    () => props.user,
    () => {
        form.permissions = props.user?.permissions,
        form.roles = props.user?.roles
    },
);
</script>

<template>
    <AdminLayout>
        <Head title="Crear Usuario" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg pb-1">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Crear Nuevo Usuario</h1>
                        <Link :href="route('users.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class="mx-5 mb-5 bg-slate-600 p-2 rounded-md">
                        <form @submit.prevent="submit" id="user">
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
<!--
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
-->
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Actualizar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="px-6 py-2"><h1 class="text-2xl font-semibold text-lime-50">Roles</h1>
                    <div class="m-2 dark:bg-gray-600">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>ID</TableHeaderCell>
                                    <TableHeaderCell>Nombre</TableHeaderCell>
                                    <TableHeaderCell>Acción</TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="UserRoles in user.roles" :key="UserRoles.id" class="border-b">
                                    <TableDataCell>{{UserRoles.id}}</TableDataCell>
                                    <TableDataCell>{{UserRoles.name}}</TableDataCell>
                                    <TableDataCell>
                                        <Link
                                            :href="route('users.roles.revoke', [user.id, UserRoles.id])"
                                            method="DELETE" as="button"
                                            class="p-1 bg-red-600 rounded-md text-lg text-bold hover:bg-red-300"
                                            preserve-scroll
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                                        </Link>
                                    </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </div>
                <div class="px-6 py-2"><h1 class="text-2xl font-semibold text-lime-50">Permisos</h1>
                    <div class="m-2 dark:bg-gray-600">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>ID</TableHeaderCell>
                                    <TableHeaderCell>Nombre</TableHeaderCell>
                                    <TableHeaderCell>Acción</TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="UserPermission in user.permissions" :key="UserPermission.id" class="border-b">
                                    <TableDataCell>{{UserPermission.id}}</TableDataCell>
                                    <TableDataCell>{{UserPermission.name}}</TableDataCell>
                                    <TableDataCell>
                                        <Link
                                            :href="route('users.permissions.revoke', [user.id, UserPermission.id])"
                                            method="DELETE" as="button"
                                            class="p-1 bg-red-600 rounded-md text-lg text-bold hover:bg-red-300"
                                            preserve-scroll
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                                        </Link>
                                    </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
