<script setup>
import {ref} from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { usePermission } from '@/composables/permissions';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps(['posts']);
const form = useForm({});
const { hasPermission} = usePermission();

const showConfirmDelPost = ref(false);
const confirmDelPost = () => {
    showConfirmDelPost.value = true;
};
const closeModal = () => {
    showConfirmDelPost.value = false;
};
const deletePost = (id) => {
    form.delete(route('posts.destroy', id), {
        onSuccess: () => closeModal()
    });
};
</script>

<template>
    <Head title="Posts" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Posts</h1>
                        <template v-if="hasPermission('Editar Posts')">
                            <Link :href="route('posts.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Nuevo Post</Link>
                        </template>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell>ID</TableHeaderCell>
                                    <TableHeaderCell>Título</TableHeaderCell>
                                    <TableHeaderCell></TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="post in posts" :key="post.id" class="border-b">
                                    <TableDataCell>{{post.id}}</TableDataCell>
                                    <TableDataCell>{{post.title}}</TableDataCell>
                                    <TableDataCell>
                                        <template v-if="hasPermission('Editar Posts')">
                                            <Link :href="route('posts.edit',post.id)" class="p-2 text-lg text-green-300 hover:text-indigo-700">Editar</Link>
                                            <button @click="confirmDelPost" class="p-2 text-lg text-red-500 hover:text-indigo-700" >Eliminar</button>
                                            <Modal :show="showConfirmDelPost" @close="closeModal">
                                                <div class="p-6">
                                                    <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar el rol {{post.title}}?</h2>
                                                    <div class="mt-6 flex space-x-4">
                                                        <DangerButton @click="$event=>deletePost(post.id)">Eliminar</DangerButton>
                                                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                    </div>
                                                </div>
                                            </Modal>
                                        </template>
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
