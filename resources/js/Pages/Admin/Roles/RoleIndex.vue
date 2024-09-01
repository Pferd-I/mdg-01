<script setup>
import {ref} from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps(['roles']);
const form = useForm({});

const showConfirmDelRole = ref(false);
const confirmDelRole = () => {
    showConfirmDelRole.value = true;
};
const closeModal = () => {
    showConfirmDelRole.value = false;
};
const deleteRole = (id) => {
    form.delete(route('roles.destroy', id), {
        onSuccess: () => closeModal()
    });
};
</script>

<template>
    <Head title="Roles de Usuarios" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Roles</h1>
                        <Link :href="route('roles.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Nuevo Rol</Link>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>ID</TableHeaderCell>
                                    <TableHeaderCell>Nombre</TableHeaderCell>
                                    <TableHeaderCell></TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="role in roles" :key="role.id" class="border-b">
                                    <TableDataCell>{{role.id}}</TableDataCell>
                                    <TableDataCell>{{role.name}}</TableDataCell>
                                    <TableDataCell>
                                        <Link :href="route('roles.edit',role.id)" class="p-2 text-lg text-green-300 hover:text-indigo-700">Editar</Link>
                                        <button @click="confirmDelRole" class="p-2 text-lg text-red-500 hover:text-indigo-700" >Eliminar</button>
                                        <Modal :show="showConfirmDelRole" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar el rol {{role.name}}?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="$event=>deleteRole(role.id)">Eliminar</DangerButton>
                                                    <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                </div>
                                            </div>
                                        </Modal>
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
