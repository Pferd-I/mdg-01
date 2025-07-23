<script setup>
import {computed, ref, reactive } from 'vue';
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
const Cur_showModal = ref(false);

const Niv_mostrarBorrados = ref(false);
const Par_mostrarBorrados = ref(false);
const Cur_mostrarBorrados = ref(false);

const niv_hab = ref([]);
const check_niv_hab = () =>{
    niv_hab.value = [];
    props.niveles.forEach(e => {
        e.estado ? niv_hab.value.push(e): "";
    });
};

const Niv_form = useForm({
    id: '',
    nombre_nivel: '',
    estado: '',
});
const C_form = useForm({
    id: '',
    grado: '',
    nro_grado: '',
    id_nivel: '',
    id_paralelo: '',
    gestion: '',
    estado: '',
});
const Niv_openModal = (n) => {
    Niv_showModal.value = true;
    Niv_form.id = n.id;
    Niv_form.nombre_nivel = n.nombre_nivel;
    Niv_form.estado = n.estado;
}
const Cur_openModal = (c) => {
    check_niv_hab();
    Cur_showModal.value = true;
    C_form.id = c.id;
    C_form.grado = c.grado;
    C_form.nro_grado = c.nro_grado;
    C_form.id_nivel = c.id_nivel;
    C_form.id_paralelo = c.id_paralelo;
    C_form.gestion = c.gestion;
    C_form.estado = c.estado;
};
function Niv_guardarCambios(){
    Niv_form.put(route('nivels.update', Niv_form.id),{
        onSuccess: () => {
            Niv_showModal.value = false;
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el nivel.");
        }
      });
};
function Cur_guardarCambios(){
    C_form.put(route('cursos.update', C_form.id),{
        onSuccess: () => {
            Cur_showModal.value = false;
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el curso.");
        }
      });
};
function Niv_eliminar(id){
    alert(id);
}
function closeM(){
    Niv_showModal.value = false;
};
function closeCM(){
    Cur_showModal.value = false;
};
</script>

<template><!---->
    <Head title="Configuración de Aulas" />

    <AdminLayout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 flex-wrap flex">
                <div class="mb-1">
                    <!--Tabla de Niveles-->
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                        <div class="mt-6 overflow-hidden">
                            <Table class="overflow-hidden" >
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell>
                                            Niveles
                                        </TableHeaderCell>
                                        <TableHeaderCell></TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow v-for="nivel in niveles" :key="nivel.id" class="border-t" :class="{'dark:bg-red-800': !nivel.estado}">
                                        <TableDataCell v-if="nivel.estado || Niv_mostrarBorrados">{{nivel.nombre_nivel}}</TableDataCell>
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
                                            <!--Modal de Nivel-->
                                            <div v-if="Niv_showModal" class="modal-overlay z-40">
                                                <div class="p-1 bg-darkblue rounded-md  w-min">
                                                    <div class="z-50" v-on:click="closeM">X</div>
                                                    <div class="p-1 bg-pewter rounded-md">
                                                        <div class="modal-content p-4 w-auto h-1/5 bg-darkblue text-pewter">
                                                            <form @submit.prevent="Niv_guardarCambios" class=" text-slate-900 overflow-hidden">
                                                            <input id="nombre_nivel" type="text" v-model="Niv_form.nombre_nivel">
                                                            <div class="w-fit font-bold text-pewter">
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
                                                            <!--
                                                            <PrimaryButtonL v-on:click="Niv_eliminar(Niv_form.id)" :class="{ 'opacity-25': Niv_form.processing }" :disabled="Niv_form.processing" class="bg-red-800">
                                                                Eliminar
                                                            </PrimaryButtonL>-->
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fin Modal de Nivel-->
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                    <!--Tabla Paralelos-->
                    <div class="mt-2 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-56 h-min">
                        <div class="mt-6">
                            <Table>
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell> Paralelos</TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow class="border-t" v-for="P in paralelos" :key="P.id">
                                        <TableDataCell>{{P.nombre_paralelo}}</TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            <!--Tablas Cursos-->
                <!--Inicial-->
                <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min mb-1">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 font-bold text-2xl">Inicial</h1>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #default>
                                <TableRow v-for="I in cursosInicial" :key="I.id" class="border-t">
                                        <TableDataCell v-if="I.estado || Cur_mostrarBorrados">{{I.grado}} {{I.paralelo}}</TableDataCell>
                                        <TableDataCell>
                                            <button @click.prevent="Cur_openModal(I)">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </button>
                                            <!--Modal de Curso-->
                                            <div v-if="Cur_showModal" class="modal-overlay z-40">
                                                <div class="p-1 bg-darkblue rounded-md  w-min">
                                                    <div class="z-50" v-on:click="closeCM">X</div>
                                                    <div class="p-1 bg-pewter rounded-md">
                                                        <div class="modal-content p-4 w-auto h-1/5 bg-darkblue text-pewter">

                                                            <form @submit.prevent="Cur_guardarCambios" class=" text-slate-900 overflow-hidden">
                                                                <input class="w-32" id="grado" type="text" v-model="C_form.grado">
                                                                <input class="ml-1 w-16" v-if="C_form.id_nivel != 1" id="nro_grado" type="text" v-model="C_form.nro_grado">
                                                                <div class="mt-1 w-fit font-bold text-pewter">
                                                                    <div class="mb-1"><label for="nombre_paralelo">Paralelo: </label>
                                                                    <select id="nombre_paralelo" v-model="C_form.id_paralelo" class="text-slate-900">
                                                                        <option v-for="p in paralelos" :value="p.id">
                                                                            <p v-if="p.estado == 1" >{{ p.nombre_paralelo }}</p>
                                                                        </option>
                                                                    </select></div>
                                                                    <label for="nombre_nivel">Nivel: </label>
                                                                    <select id="nombre_nivel" v-model="C_form.id_nivel" class="text-slate-900">
                                                                        <option v-for="N in niv_hab" :value="N.id">
                                                                            <p v-if="N.estado == 1" >{{ N.nombre_nivel }}</p>
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="w-fit font-bold text-pewter">
                                                                    <div v-if="C_form.estado" class="bg-green-800">
                                                                        <p class="m-2">Activo</p>
                                                                    </div>
                                                                    <div v-else class=" bg-red-800">
                                                                        <p class="m-2">Inactivo</p>
                                                                    </div>
                                                                </div>
                                                                <PrimaryButtonL :class="{ 'opacity-25': C_form.processing }" :disabled="C_form.processing">
                                                                    Actualizar
                                                                </PrimaryButtonL>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fin Modal de Curso-->
                                        </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </div>
                <!--Primaria-->
                <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min mb-1">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 font-bold text-2xl">Primaria</h1>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #default>
                                <TableRow v-for="P in cursosPrimaria" :key="P.id" class="border-t">
                                        <TableDataCell>{{P.grado}} {{P.paralelo}}</TableDataCell>
                                        <TableDataCell><button @click.prevent="Cur_openModal(P)">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg></button>
                                            <!--Modal de Primaria-->
                                            <!--Fin Modal de Primaria-->
                                        </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </div>
                <!--Secundaria-->
                <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto mb-1">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 font-bold text-2xl">Secundaria</h1>
                    </div>
                    <div class="mt-6">
                        <Table>
                            <template #default>
                                <TableRow v-for="S in cursosSecundaria" :key="S.id" class="border-t">
                                        <TableDataCell>{{S.grado}} {{S.paralelo}}</TableDataCell>
                                        <TableDataCell><button  @click.prevent="Cur_openModal(S)">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg></button>
                                            <!--Modal de Sec-->
                                            <!--Fin Modal de Sec-->
                                        </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </div>
                <!--Checks de Eliminados-->
                <div>
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                        <div class="mx-2">
                            <input type="checkbox" id="Nivcheckbox" v-model="Niv_mostrarBorrados" />
                            <label for="Nivcheckbox" class=" text-pewter font-bold"> Todos los Niveles y Paralelos</label>
                        </div>
                        <div class="mx-2">
                            <input type="checkbox" id="Curcheckbox" v-model="Cur_mostrarBorrados" />
                            <label for="Curcheckbox" class=" text-pewter font-bold"> Todos los Cursos</label>
                        </div>
                    </div>
                </div>
                <!--Fin Checks de Eliminados-->
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
