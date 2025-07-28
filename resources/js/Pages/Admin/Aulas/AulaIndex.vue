<script setup>
import {computed, ref, reactive } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import NivUpdate from '@/Components/Aulas/NivelModalUpdate.vue';
import ParCreate from '@/Components/Aulas/ParaleloModalCreate.vue';
import ParUpdate from '@/Components/Aulas/ParaleloModalUpdate.vue';
import CurCreate from '@/Components/Aulas/CursoModalCreate.vue';
import CurUpdate from '@/Components/Aulas/CursoModalUpdate.vue';
import ButtonPlus from '@/Components/Aulas/SubComponentes/ButtonPlus.vue';
import Pencil from '@/Components/Aulas/SubComponentes/ButtonPencil.vue';

const props = defineProps({
    niveles: Object,
    paralelos: Array,
    cursosInicial: Object,
    cursosPrimaria: Object,
    cursosSecundaria: Object,
});

const Niv_mostrarBorrados = ref(false);
const Par_mostrarBorrados = ref(false);
const Cur_mostrarBorrados = ref(false);

const niv_hab = computed(() =>
    (props.niveles || []).filter(n => n.estado));
const par_hab = computed(() =>
    (props.paralelos || []).filter(p => p.estado));

//Nivel
const N_showModal = ref(false);
const selectedNiv = ref(null);

function Niv_openModal(nivel){
    selectedNiv.value = nivel;
    N_showModal.value = true;
};

//Paralelo
const P_showModal_C = ref(false);
const P_showModal = ref(false);
const selectedPar = ref(null);

function Par_openModal_New(){P_showModal_C.value = true};
function Par_openModal(paralelo){
    selectedPar.value = paralelo;
    P_showModal.value = true;
};

//Curso
const Cur_showModal_C = ref(false);
const Cur_showModal = ref(false);
const selectedCur = ref(null);

function Cur_openModal_New(){Cur_showModal_C.value = true};
const Cur_openModal = (curso) => {
    selectedCur.value = curso;
    Cur_showModal.value = true;
};
</script>

<template><!---->
    <Head title="Configuración de Aulas" />
    <AdminLayout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 flex-wrap flex">
                <div class="mb-1 mr-6 lg:block flex">
                    <!--Checks de Eliminados-->
                    <div>
                        <div class="mx-2 my-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                            <div class="mx-2">
                                <input type="checkbox" id="Curcheckbox" v-model="Cur_mostrarBorrados" />
                                <label for="Curcheckbox" class=" text-pewter font-bold"> Todos los Cursos</label>
                            </div>
                            <div class="mx-2">
                                <input type="checkbox" id="Parcheckbox" v-model="Par_mostrarBorrados" />
                                <label for="Parcheckbox" class=" text-pewter font-bold"> Todos los Paralelos</label>
                            </div>
                        </div>
                    </div>
                    <!--Tabla de Niveles-->
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                        <div class="mt-6">
                            <Table class="overflow-hidden">
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell>Niveles</TableHeaderCell>
                                        <TableHeaderCell/>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow v-for="nivel in niveles" :key="nivel.id" class="border-t" :class="{'dark:bg-red-800': !nivel.estado}">
                                        <TableDataCell v-if="nivel.estado || Niv_mostrarBorrados">{{nivel.nombre_nivel}}</TableDataCell>
                                        <TableDataCell v-if="nivel.estado || Niv_mostrarBorrados">
                                            <Pencil @click.prevent="Niv_openModal(nivel)"/>
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                    <!--Tabla Paralelos-->
                    <div class="mt-2 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                        <div class="mt-6">
                            <Table class="overflow-hidden">
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell> Paralelos</TableHeaderCell>
                                        <ButtonPlus @click="Par_openModal_New"/>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow class="border-t" v-for="P in paralelos" :key="P.id"  :class="{'dark:bg-red-800': !P.estado}">
                                        <TableDataCell v-if="P.estado || Par_mostrarBorrados">{{P.nombre_paralelo}}
                                        </TableDataCell>
                                        <TableDataCell v-if="P.estado || Par_mostrarBorrados">
                                            <Pencil @click.prevent="Par_openModal(P)"/>
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
                <!--Tablas Cursos-->
                <div class="ml-5 p-3 bg-slate-600 w-auto rounded-md">
                    <div class="p-1 font-bold text-2xl text-pewter border-b mb-2">
                        Cursos
                    <ButtonPlus @click="Cur_openModal_New"/>
                    </div>
                    <div class="flex">
                        <!--Inicial-->
                        <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min mb-1">
                            <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                                <h1 class="ml-3 font-bold text-2xl">Inicial</h1>
                            </div>
                            <div class="mt-6">
                                <Table class="overflow-hidden">
                                    <template #default>
                                        <TableRow v-for="I in cursosInicial" :key="I.id" class="border-t" :class="{'dark:bg-red-800': !I.estado}">
                                                <TableDataCell v-if="I.estado || Cur_mostrarBorrados">{{I.grado}} {{I.paralelo}}</TableDataCell>
                                                <TableDataCell  v-if="I.estado || Cur_mostrarBorrados">
                                                    <Pencil @click.prevent="Cur_openModal(I)"/>
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
                                <Table class="overflow-hidden">
                                    <template #default>
                                        <TableRow class="border-t" v-for="P in cursosPrimaria" :key="P.id" :class="{'dark:bg-red-800': !P.estado}">
                                                <TableDataCell v-if="P.estado || Cur_mostrarBorrados">{{P.grado}} {{P.paralelo}}</TableDataCell>
                                                <TableDataCell v-if="P.estado || Cur_mostrarBorrados">
                                                    <Pencil @click.prevent="Cur_openModal(P)"/>
                                                </TableDataCell>
                                        </TableRow>
                                    </template>
                                </Table>
                            </div>
                        </div>
                        <!--Secundaria-->
                        <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min mb-1">
                            <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                                <h1 class="ml-3 font-bold text-2xl">Secundaria</h1>
                            </div>
                            <div class="mt-6">
                                <Table class="overflow-hidden">
                                    <template #default>
                                        <TableRow v-for="S in cursosSecundaria" :key="S.id" class="border-t" :class="{'dark:bg-red-800': !S.estado}">
                                                <TableDataCell v-if="S.estado || Cur_mostrarBorrados">{{S.grado}} {{S.paralelo}}</TableDataCell>
                                                <TableDataCell v-if="S.estado || Cur_mostrarBorrados">
                                                    <Pencil @click.prevent="Cur_openModal(S)"/>
                                                </TableDataCell>
                                        </TableRow>
                                    </template>
                                </Table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="font-medium text-base text-gray-900 whitespace-nowrap dark:text-white">
                    <!--NIVEL Update-->
                    <NivUpdate :nivel="selectedNiv" v-if="N_showModal" @close="N_showModal = false"/>

                    <!--PARALELO Create-->
                    <ParCreate v-if="P_showModal_C" @close="P_showModal_C = false"/>
                    <!--Update & Delete-->
                    <ParUpdate :paralelo="selectedPar" v-if="P_showModal" @close="P_showModal = false"/>
                    <!---->

                    <!--CURSO Create-->
                    <CurCreate :niveles="niv_hab" :paralelos="par_hab" v-if="Cur_showModal_C" @close="Cur_showModal_C = false"/>
                    <!--Update & Delete-->
                    <CurUpdate :curso="selectedCur" :niveles="niv_hab" :paralelos="par_hab" v-if="Cur_showModal" @close="Cur_showModal = false"/>
                    <!---->
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
