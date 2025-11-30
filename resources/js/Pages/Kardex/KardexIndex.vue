<script setup>
import {ref, watch, onBeforeUnmount} from 'vue';
import { Head, Link, useForm, router, usePage} from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Info from '@/Components/Subcomponents/ButtonInfo.vue';
import Plus from '@/Components/Subcomponents/ButtonPlus.vue';
import Pencil from '@/Components/Subcomponents/ButtonPencil.vue';
import Toast from '@/Components/AlertMessage.vue'
import debounce from 'lodash/debounce';
import Pagination from '@/Components/Pagination.vue';

import ObsCreate from '@/Components/Kardex/Observaciones/ObsCreate.vue';
import ObsUpdate from '@/Components/Kardex/Observaciones/ObsUpdate.vue';
import ObsInfo from '@/Components/Kardex/Observaciones/ObsInfo.vue';

const props = defineProps({
  observaciones: Object,
  estudiantes: Array,
  plantel: Array,
  cursos: Array,
  asignaturas: Array,
  tipos_observacion: Array,
  mi_plantel: Object,
  filters: Object,
  flash : Object,
});
//Mostrar eliminados
const Obs_mostrarBorrados = ref(false);
//Nueva observación
const Obs_showModal_C = ref(false);
function Obs_openModal_New(){
  Obs_showModal_C.value = true;
}
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
//Info
const selectedObs = ref(null);
const Obs_showModal_I = ref(false);
function Obs_openModal_Info(obs){
  selectedObs.value = obs;
  Obs_showModal_I.value = true;
}
//Edit
const Obs_showModal_U = ref(false);
function Obs_openModal_Upda(obs){
    Obs_showModal_U.value = true;
    selectedObs.value = obs;
}
// Búsqueda
const search = ref(props.filters.search || '');
const debouncedSearch = debounce(() => {
  router.get(route('kardex.index'), { search: search.value }, {
    preserveState: true,
    replace: true,
  });
}, 200);
watch(search, () => {
  debouncedSearch();
});
onBeforeUnmount(() => {
  debouncedSearch.cancel();
});
</script>

<template>
    <Head title="Observaciones" />

    <UserLayout>
        <Toast v-if="page.props.flash.error" :message="page.props.flash.error" type="error" />
        <Toast v-if="page.props.flash.success" :message="page.props.flash.success" type="success" />
        <div class="py-12 flex">
            <div class="mx-auto sm:px-2 lg:px-4 w-full flex">
                <div class="overflow-hidden shadow-sm sm:rounded-lg w-2/3">
                    <!--Checks de Eliminados-->
                    <div>
                        <div class="p-2 my-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto">
                            <div class="mx-2">
                                <input type="checkbox" id="Obscheckbox" v-model="Obs_mostrarBorrados"/>
                                <label for="Obscheckbox" class="ml-1 my-auto text-pewter font-bold"> Mostrar todas las Observaciones</label>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-slate-600 w-auto rounded-md">
                        <div class="p-1 font-bold text-2xl text-pewter border-b mb-2">
                        Lista de Observaciones
                        </div>
                        <div class="mt-2 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                            <div class="">
                                <div class="p-2 flex justify-between items-center">
                                    <input class="input input-bordered w-full max-w-md text-darkblue-800 font-bold rounded-md ml-1" id="busqueda"
                                        v-model="search" type="text" placeholder="Buscar por estudiante, docente, tipo o fecha..."/>
                                    <div>
                                        <Plus @click="Obs_openModal_New" class=""/>
                                    </div>

                                </div>
                                <Table>
                                    <template #header>
                                        <TableRow>
                                            <TableHeaderCell>Fecha</TableHeaderCell>
                                            <TableHeaderCell>Estudiante</TableHeaderCell>
                                            <TableHeaderCell>Tipo</TableHeaderCell>
                                            <TableHeaderCell></TableHeaderCell>
                                        </TableRow>
                                    </template>
                                    <template #default>
                                        <TableRow v-for="obs in observaciones.data" :key="obs.id" class="border-b"  :class="{'dark:bg-red-800': !obs.estado}">
                                            <template v-if="obs.estado || Obs_mostrarBorrados" class=" overflow-hidden">
                                            <TableDataCell>{{obs.fecha_evento}}</TableDataCell>
                                            <TableDataCell>{{obs.estudiante.apellido_p}} {{obs.estudiante.apellido_m}} {{obs.estudiante.nombres}}</TableDataCell>
                                            <TableDataCell>{{obs.tipo}}</TableDataCell>
                                            <TableDataCell>
                                                <Info @click="Obs_openModal_Info(obs)"/>
                                                <Pencil @click="Obs_openModal_Upda(obs)" class="p-2 text-lg text-green-300 hover:text-indigo-700">Editar</Pencil>
                                                <!--<ButtonDelete @click="confirmDeleteObs" class="p-2 text-lg text-red-500 hover:text-indigo-700" />
                                                <Modal :show="showConfirmDelObs" @close="closeModal">
                                                    <div class="p-6">
                                                        <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar la entrada?</h2>
                                                        <div class="mt-6 flex space-x-4">
                                                            <DangerButton @click="$event=>deleteObs(ppff.id)">Eliminar</DangerButton>
                                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                        </div>
                                                    </div>
                                                </Modal>-->
                                            </TableDataCell>
                                            </template>
                                        </TableRow>
                                    </template>
                                </Table>
                                <Pagination :links="observaciones.links" />
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <!--Modales-->
                <div class="font-medium text-base text-gray-900 whitespace-nowrap dark:text-white">
                    <ObsCreate v-if="Obs_showModal_C" @close="Obs_showModal_C = false"
                        :estudiantes="estudiantes" :plantel="plantel" :cursos="cursos" :asignaturas="asignaturas"
                        :tipos_observacion="tipos_observacion" :mi_plantel="mi_plantel"/>
                    <ObsUpdate v-if="Obs_showModal_U && selectedObs" @close="Obs_showModal_U = false"
                        :observacion="selectedObs" :estudiantes="estudiantes" :plantel="plantel" :cursos="cursos" :asignaturas="asignaturas"
                        :tipos_observacion="tipos_observacion" :mi_plantel="mi_plantel"/>
                    <ObsInfo v-if="Obs_showModal_I && selectedObs" @close="Obs_showModal_I = false"
                        :observacion="selectedObs"/>
                </div>
            </div>
            <div class="bg-green w-1/3 h-2/3">
                <div class="h-full w-full bg-black">
                    <button class="btn btn-primary m-4 w-auto" @click="router.visit(route('asistencia.index'))">
                        Ir a Asistencias
                    </button>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
