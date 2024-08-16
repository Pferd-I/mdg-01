<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
defineProps(['permissions'])
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
                                        <Link :href="route('permissions.destroy',permission.id)" method="DELETE" as="button" class="p-2 text-lg text-red-500 hover:text-indigo-700">Eliminar</Link>
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
