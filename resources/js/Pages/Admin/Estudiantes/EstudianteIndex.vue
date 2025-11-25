<script setup>
import {computed, ref, reactive, watch, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';


import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Info from '@/Components/Subcomponents/ButtonInfo.vue';
import ButtonPlus from '@/Components/Subcomponents/ButtonPlus.vue';
import Pencil from '@/Components/Subcomponents/ButtonPencil.vue';
import Toast from '@/Components/AlertMessage.vue'

import EstCreate from '@/Components/Estudiantes/EstudianteModalCreate.vue';
import EstInfo from '@/Components/Estudiantes/EstudianteModalInfo.vue';
import EstUpda from '@/Components/Estudiantes/EstudianteModalEdit.vue';

const props = defineProps({
    'estudiantes': Array,
    'cursos': Array,
    'tipos_beca': Array,
    'flash' : Object
});

//Mostrar eliminados
const Est_mostrarBorrados = ref(false);
//Nuevo
const E_showModal_C = ref(false);
function Est_openModal_New(){ E_showModal_C.value = true;}

//Info
const E_showModal_I = ref(false);
const selectedEst = ref(null);
function Est_openModal_Info(est){
    E_showModal_I.value = true;
    selectedEst.value = est;
}

//Edit
const E_showModal_U = ref(false);
function Est_openModal_Upda(est){
    E_showModal_U.value = true;
    selectedEst.value = est;
}

//Búsqueda
const busqueda = ref('');
let timeout = null;

watch(busqueda, (nuevoValor) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            route('estudiantes.index'),
            { search: nuevoValor },
            { preserveState: true, replace: true }
        );
    }, 500);
});

//Mensaje flash
const page = usePage();
const flashMessage = ref(page.props.flash?.success || null);
watch(
  () => page.props.flash?.success,
  (val) => {
    flashMessage.value = val;
    if (val) {
      setTimeout(() => (flashMessage.value = null), 4000);
    }
  }
);

</script>
<template><!---->
    <Head title="Estudiantes"/>
    <AdminLayout>
        <Toast v-if="page.props.flash.error" :message="page.props.flash.error" type="error" />
        <Toast v-if="page.props.flash.success" :message="page.props.flash.success" type="success" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-wrap flex">
                <div class="mb-1 mr-6 lg:block flex">
                    <!--Checks de Eliminados-->
                    <div>
                        <div class="ml-5 p-2 my-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                            <div class="mx-2">
                                <input type="checkbox" id="Curcheckbox" v-model="Est_mostrarBorrados" />
                                <label for="Curcheckbox" class=" text-pewter font-bold"> Todos los Estudiantes</label>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5 p-3 bg-slate-600 w-auto rounded-md">
                        <div class="p-1 font-bold text-2xl text-pewter border-b mb-2">
                        Lista de Estudiantes
                            <ButtonPlus @click="Est_openModal_New"/>
                        </div>
                        <div class="mt-2 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                            <label for="busqueda"/> <input v-model="busqueda" id="busqueda" type="text" placeholder="Buscar estudiante..." class="m-3 border rounded px-3 py-2 w-11/12"/>
                            <div class="mt-6 overflow-x-auto">
                                <Table class="min-w-full border-collapse">
                                    <template #header>
                                        <TableRow>
                                            <TableHeaderCell class="hidden md:table-cell">CI</TableHeaderCell>
                                            <TableHeaderCell class="hidden md:table-cell">RUDE</TableHeaderCell>
                                            <TableHeaderCell>Estudiante</TableHeaderCell>
                                            <TableHeaderCell>Curso</TableHeaderCell>
                                            <TableHeaderCell class="hidden md:table-cell">Tipo de Beca</TableHeaderCell>
                                            <TableHeaderCell></TableHeaderCell>
                                        </TableRow>
                                    </template>
                                    <template #default>
                                        <TableRow v-for="e in estudiantes" :key="e.id" class="border-t" :class="{'dark:bg-red-800': !e.estado}">
                                            <template v-if="e.estado || Est_mostrarBorrados" class=" overflow-hidden">
                                            <TableDataCell class="hidden md:table-cell">{{e.ci}}</TableDataCell>
                                            <TableDataCell class="hidden md:table-cell">{{e.rude}}</TableDataCell>
                                            <TableDataCell>{{e.apellido_p}} {{e.apellido_m}} {{e.nombres}}</TableDataCell>
                                            <TableDataCell>
                                                <template v-if="['Inicial'].includes(e.curso.nivel.nombre_nivel)">
                                                    {{ e.curso.nro_grado }}
                                                </template>
                                                <template v-else>
                                                    {{ e.curso.nro_grado }}º {{ e.curso.nivel.nombre_nivel }}
                                                </template>
                                            </TableDataCell>
                                            <TableDataCell class="hidden md:table-cell">{{e.tipo_beca.nombre_tipo_beca}}</TableDataCell>
                                            <TableDataCell>
                                                <Info @click.prevent="Est_openModal_Info(e)" class="mr-2"/>
                                                <Pencil @click.prevent="Est_openModal_Upda(e)"/>
                                            </TableDataCell></template>
                                        </TableRow>
                                    </template>
                                </Table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="font-medium text-base text-gray-900 whitespace-nowrap dark:text-white">
                    <EstCreate v-if="E_showModal_C" @close="E_showModal_C = false"
                        :tipos_beca="tipos_beca" :cursos="cursos"/>
                    <EstInfo v-if="E_showModal_I && selectedEst" @close="E_showModal_I = false"
                        :estudiante="selectedEst"/>
                    <EstUpda v-if="E_showModal_U && selectedEst" @close="E_showModal_U = false"
                        :estudiante="selectedEst" :tipos_beca="tipos_beca" :cursos="cursos"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
