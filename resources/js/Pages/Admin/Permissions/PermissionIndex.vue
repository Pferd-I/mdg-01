<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps(['permissions']);
const form = useForm({});

const showConfirmDelPermission = ref(false);
const confirmDelPermission = () => {
    showConfirmDelPermission.value = true;
};
const closeModal = () => {
    showConfirmDelPermission.value = false;
};
const deletePermission = (id) => {
    form.delete(route('permissions.destroy', id), {
        onSuccess: () => closeModal()
    });
};
</script>

<template>
    <Head title="Permisos" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Permisos</h1>
                        <Link :href="route('permissions.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Nuevo Rol</Link>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>ID</TableHeaderCell>
                                    <TableHeaderCell>Nombre</TableHeaderCell>
                                    <TableHeaderCell>Acción</TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="permission in permissions" :key="permission.id" class="border-b">
                                    <TableDataCell>{{permission.id}}</TableDataCell>
                                    <TableDataCell>{{permission.name}}</TableDataCell>
                                    <TableDataCell>
                                        <Link :href="route('permissions.edit',permission.id)" class="p-2 text-lg text-green-300 hover:text-indigo-700">Editar</Link>
                                        <button @click="confirmDelPermission" class="p-2 text-lg text-red-500 hover:text-indigo-700" >Eliminar</button>
                                        <Modal :show="showConfirmDelPermission" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar el permiso {{permission.name}}?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="$event=>deletePermission(permission.id)">Eliminar</DangerButton>
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
