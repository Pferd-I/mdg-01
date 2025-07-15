<script setup>
import {ref, reactive, defineEmits} from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Aulas/Modal.vue'
import PrimaryButtonL from '@/Components/PrimaryButtonModal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

defineProps(['niveles']);

const showModal = ref(false);

const form= reactive({
    id:'',
    nombre_nivel: '',
    estado: '',
});

const openModal = (nivel) => {
  showModal.value = true;
  form.id = nivel.id;
  form.nombre_nivel = nivel.nombre_nivel;
  form.estado = nivel.estado;
};
function closeM(){
    showModal.value = false;
};
</script>

<template>
    <Head title="Configuración de Aulas" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/4">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 font-bold text-2xl">Niveles</h1>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #default>
                                <TableRow class="border-b"></TableRow>
                                <TableRow v-for="nivel in niveles" :key="nivel.id"  class="border-b">
                                    <TableDataCell>{{nivel.nombre_nivel}}</TableDataCell>
                                    <TableDataCell>
                                        <button @click.prevent="openModal(nivel)">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                            </svg>
                                        </button><!--
                                        <Modal :isOpen="showModal" :nivel="selectedNivel" @close="showModal = false" />
-->

                                        <div v-if="showModal" class="modal-overlay z-40 ">
                                            <div class="p-1 bg-darkblue rounded-md w-1/3">
                                                <div class="p-1 bg-pewter rounded-md">
                                                    <div class="modal-content p-4 w-auto h-1/5 bg-darkblue text-pewter">
                                                        <button v-on:click="closeM" class=" btn-danger"> X</button>
                                                        <form @submit.prevent="form.put(route('niveles.update', nivel.id))" class="md:flex lg:block">
                                                            <div class="md:shrink-0">
                                                                <div class="py-2">
                                                                    <InputLabel id="Nombre" for="nombre_nivel" value="Nombre:" class="text-xl" />
                                                                    <TextInput id="nombre_nivel" type="text" class="mt-1 block w-2/5 text-2xl" v-model="form.nombre_nivel"/>
                                                                </div>
                                                                <div class="py-2 flex-wrap">
                                                                    <InputLabel id="Estado" for="estado" value="Estado:" class="w-min text-xl" />
                                                                    <p class="w-min">
                                                                    <InputLabel id="estado" v-if="form.estado = 1" value="Activo" class="text-xl bg-lime-600 p-2 w-min h-min rounded-md" />
                                                                    <InputLabel id="estado" v-else value="Inactivo" class="text-xl bg-red-700 p-2 w-min h-min rounded-md" />
                                                                    </p>
                                                                </div>
                                                                <div class="flex-wrap items-center overflow-clip">
                                                                    <PrimaryButtonL class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                                        Actualizar
                                                                    </PrimaryButtonL>
                                                                    <PrimaryButtonL class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                                        Eliminar
                                                                    </PrimaryButtonL>
                                                                    <PrimaryButtonL class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                                        Eliminar
                                                                    </PrimaryButtonL>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    <!--<button @click="close">Cerrar</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




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
<style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  </style>
