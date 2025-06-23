<script setup>
import {ref} from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps(['ppffs']);
const form = useForm({});

const showConfirmDelPpff = ref(false);
const confirmDeletePpff = () => {
    showConfirmDelPpff.value = true;
};
const closeModal = () => {
    showConfirmDelPpff.value = false;
};
const deletePpff = (id) => {
    form.delete(route('ppffs.destroy', id), {
        onSuccess: () => closeModal()
    });
};
</script>

<template>
    <Head title="Padres de Familia" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-darkblue-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-100 flex justify-between">
                        <h1 class="ml-3 text-2xl">Padres de Familia y Tutores</h1>
                        <Link :href="route('ppffs.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded duration-300">Nuevo PPFF</Link>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>CI</TableHeaderCell>
                                    <TableHeaderCell>Nombre</TableHeaderCell>
                                    <TableHeaderCell>Dirección</TableHeaderCell>
                                    <TableHeaderCell>Contacto</TableHeaderCell>
                                    <TableHeaderCell></TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="ppff in ppffs" :key="ppff.id" class="border-b">
                                    <TableDataCell>{{ppff.cionit}}</TableDataCell>
                                    <TableDataCell>{{ppff.nombre}}</TableDataCell>
                                    <TableDataCell>{{ppff.direccion}}</TableDataCell>
                                    <TableDataCell><Link class="p-2 text-lg text-blue-200 hover:text-indigo-700">Call</Link></TableDataCell>
                                    <TableDataCell>
                                        <Link class="p-2 text-lg text-blue-200 hover:text-indigo-700">Detalles</Link>
                                        <Link :href="route('ppffs.edit',ppff.id)" class="p-2 text-lg text-green-300 hover:text-indigo-700">Editar</Link>
                                        <!--
                                        <Link :href="route('users.destroy',user.id)" method="DELETE" as="button" class="p-2 text-lg text-red-500 hover:text-indigo-700">Eliminar</Link>
                                        -->
                                        <button @click="confirmDeletePpff" class="p-2 text-lg text-red-500 hover:text-indigo-700" >Eliminar</button>
                                        <Modal :show="showConfirmDelPpff" @close="closeModal">
                                            <div class="p-6">
                                                <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar al ppff?</h2>
                                                <div class="mt-6 flex space-x-4">
                                                    <DangerButton @click="$event=>deletePpff(ppff.id)">Eliminar</DangerButton>
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
