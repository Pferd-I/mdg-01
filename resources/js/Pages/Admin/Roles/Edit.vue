<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButtonL from '@/Components/PrimaryButtonLightContainer.vue';
import InputErrorL from '@/Components/InputErrorLightContainer.vue';
import VueMultiselect from 'vue-multiselect';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import { onMounted, watch } from 'vue';

const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: Array,
});

const form= useForm({
    name: props.role.name,
    permissions: [],
});

onMounted(() =>{
    form.permissions = props.role?.permissions;
});

watch(
    () => props.role,
    () => (form.permissions = props.role?.permissions)
)
</script>

<template>
    <Head title="Editar Rol" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class=" text-2xl font-semibold text-lime-50">Configurar el Rol</h1>
                        <Link :href="route('roles.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class=" mx-3 mb-3 bg-slate-400 p-2 rounded-md">
                        <form @submit.prevent="form.put(route('roles.update', role.id))">
                            <div>
                                <InputLabel value="Nombre" class="dark:text-slate-900" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autofocus
                                    autocomplete="username"
                                    oninvalid="this.setCustomValidity('Por favor ingrese el nombre del Rol')"
                                    oninput="setCustomValidity('')"
                                />

                                <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.name" />
                            </div>
                            <div class="mt-3">
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
                            <div class="flex items-center mt-4">
                                <PrimaryButtonL class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Actualizar
                                </PrimaryButtonL>
                            </div>
                        </form>
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
                                    <TableRow v-for="RolePermission in role.permissions" :key="RolePermission.id" class="border-b">
                                        <TableDataCell>{{RolePermission.id}}</TableDataCell>
                                        <TableDataCell>{{RolePermission.name}}</TableDataCell>
                                        <TableDataCell>
                                            <Link :href="route('roles.permissions.revoke',[role.id, RolePermission.id])" method="DELETE" as="button" class="p-1 bg-red-600 rounded-md text-lg text-bold hover:bg-red-300">
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
        </div>
    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
