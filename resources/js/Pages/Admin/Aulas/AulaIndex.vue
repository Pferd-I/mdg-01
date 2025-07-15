<script setup>
import {computed, ref} from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import PrimaryButtonL from '@/Components/PrimaryButtonModal.vue';

const props = defineProps({
    niveles: Object,
    paralelos: Object,
    cursosInicial: Object,
    cursosPrimaria: Object,
    cursosSecundaria: Object,
});
const Niv_showModal = ref(false);
const Niv_mostrarBorrados = ref(false);
const Par_mostrarBorrados = ref(false);
const Cur_mostrarBorrados = ref(false);
const Niv_form= useForm({
    id:'',
    nombre_nivel: '',
    estado: '',
});
const Niv_openModal = (n) => {
    Niv_showModal.value = true;
    Niv_form.id = n.id;
    Niv_form.nombre_nivel = n.nombre_nivel;
    Niv_form.estado = n.estado;
}
function Niv_guardarCambios(){
      Niv_form.put(route('nivels.update', Niv_form.id),{
        onSuccess: () => {
            Niv_showModal.value = false;
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el nivel.");
        }
      });
}
function Niv_eliminar(id){
    alert(id);
}
function closeM(){
    Niv_showModal.value = false;
};
</script>

<template>
    <Head title="Configuración de Aulas" />

    <AdminLayout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 flex-wrap flex">
                <div>
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-56 h-min">

                        <div class="mx-2">
                            <input type="checkbox" id="Nivcheckbox" v-model="Niv_mostrarBorrados" />
                            <label for="Nivcheckbox" class=" text-pewter font-bold"> Mostrar eliminados</label>
                        </div>
                        <div class="mt-6">
                            <Table>
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell>
                                            Niveles
                                        </TableHeaderCell>
                                        <TableHeaderCell></TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow class="border-b"></TableRow>
                                    <TableRow v-for="nivel in niveles" :key="nivel.id" class="border-b">
                                            <TableDataCell v-if="nivel.estado || Niv_mostrarBorrados" :class="{' dark:text-danger': !nivel.estado}">{{nivel.nombre_nivel}}</TableDataCell>
                                                <TableDataCell v-if="nivel.estado || Niv_mostrarBorrados">
                                                <button @click.prevent="Niv_openModal(nivel)">
                                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <div v-if="Niv_showModal" class="modal-overlay z-40">
                                                    <div class="p-1 bg-darkblue rounded-md  w-min">
                                                        <div class="z-50" v-on:click="closeM">X</div>
                                                        <div class="p-1 bg-pewter rounded-md">
                                                            <div class="modal-content p-4 w-auto h-1/5 bg-darkblue text-pewter">
                                                                <form @submit.prevent="Niv_guardarCambios" class=" text-slate-900 overflow-hidden" >
                                                                <input id="nombre_nivel" type="text" v-model="Niv_form.nombre_nivel">
                                                                <div class="p-1 w-fit font-bold text-pewter">
                                                                    <div v-if="Niv_form.estado" class="bg-green-800">
                                                                        <p class="m-2">Activo</p>
                                                                    </div>
                                                                    <div v-else class=" bg-red-800">
                                                                        <p class="m-2">Inactivo</p>
                                                                    </div>
                                                                </div>
                                                                <PrimaryButtonL :class="{ 'opacity-25': Niv_form.processing }" :disabled="Niv_form.processing">
                                                                    Actualizar
                                                                </PrimaryButtonL>
                                                                <PrimaryButtonL v-on:click="Niv_eliminar(Niv_form.id)" :class="{ 'opacity-25': Niv_form.processing }" :disabled="Niv_form.processing" class="bg-red-800">
                                                                    Eliminar
                                                                </PrimaryButtonL>
                                                            </form>
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
                    <!--Tabla Paralelos-->
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-56 h-min">

                        <div class="mt-6">
                            <Table>
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell> Paralelos</TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow class="border-b"></TableRow>
                                    <TableRow class="border-b" v-for="P in paralelos" :key="P.id">
                                        <TableDataCell>{{P.nombre_paralelo}}</TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>

                <!--Tablas Cursos-->
                <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                            <h1 class="ml-3 font-bold text-2xl">Inicial</h1>
                        </div>
                        <div class="mx-2">
                            <input type="checkbox" id="Curcheckbox" v-model="Cur_mostrarBorrados" />
                            <label for="Curcheckbox" class=" text-pewter font-bold"> Mostrar eliminados</label>
                        </div>
                        <div class="mt-6">
                            <Table>
                                <template #default>
                                    <TableRow class="border-b"></TableRow>
                                    <TableRow v-for="I in cursosInicial" :key="I.id" class="border-b">
                                            <TableDataCell>{{I.grado}} {{I.paralelo}}</TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                            <h1 class="ml-3 font-bold text-2xl">Primaria</h1>
                        </div>
                        <div class="mx-2">
                            <input type="checkbox" id="Curcheckbox" v-model="Cur_mostrarBorrados" />
                            <label for="Curcheckbox" class=" text-pewter font-bold"> Mostrar eliminados</label>
                        </div>
                        <div class="mt-6">
                            <Table>
                                <template #default>
                                    <TableRow class="border-b"></TableRow>
                                    <TableRow v-for="I in cursosPrimaria" :key="I.id" class="border-b">
                                            <TableDataCell>{{I.grado}} {{I.paralelo}}</TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                            <h1 class="ml-3 font-bold text-2xl">Secundaria</h1>
                        </div>
                        <div class="mx-2">
                            <input type="checkbox" id="Curcheckbox" v-model="Cur_mostrarBorrados" />
                            <label for="Curcheckbox" class=" text-pewter font-bold"> Mostrar eliminados</label>
                        </div>
                        <div class="mt-6">
                            <Table>
                                <template #default>
                                    <TableRow class="border-b"></TableRow>
                                    <TableRow v-for="I in cursosSecundaria" :key="I.id" class="border-b">
                                            <TableDataCell>{{I.grado}} {{I.paralelo}}</TableDataCell>
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
