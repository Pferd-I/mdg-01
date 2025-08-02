<script setup>
import {computed, ref, reactive } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import ButtonPlus from '@/Components/Subcomponents/ButtonPlus.vue';
import Pencil from '@/Components/Subcomponents/ButtonPencil.vue';
import Info from '@/Components/Subcomponents/ButtonInfo.vue';

import TbModalInfo from '@/Components/Mensualidades/TipoBModalInfo.vue';
import TbModalUpdate from '@/Components/Mensualidades/TipoBModalUpdate.vue';

const props = defineProps({
    'tipobecas':Object,
});

const showTbInfo = ref(false);
const showTbUpda = ref(false);
const selectedTB = ref(null);

function TB_openInfo(tipobeca){
    selectedTB.value = tipobeca;
    showTbInfo.value = true;
}
function TB_openUpda(tipobeca){
    selectedTB.value = tipobeca;
    showTbUpda.value = true;
}
</script>
<template><!---->
    <Head title="Mensualidades"/>
    <AdminLayout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 flex-wrap flex">
                <div class="mb-1 mr-6 lg:block flex">
                    <!--Tabla de Tipo de Becas-->
                    <div class="mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg w-auto h-min">
                        <div class="mt-6">
                            <Table class="overflow-hidden">
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell>Tipos de Beca</TableHeaderCell>
                                        <TableHeaderCell/>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow v-for="beca in tipobecas" :key="beca.id" class="border-t" :class="{'dark:bg-red-800': !beca.estado}">
                                        <TableDataCell v-if="beca.estado ">{{beca.nombre_tipo_beca}}</TableDataCell>
                                        <TableDataCell v-if="beca.estado ">
                                            <Info class="mr-2" @click.prevent="TB_openInfo(beca)"/>
                                            <Pencil @click.prevent="TB_openUpda(beca)"/>
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
                <div class="font-medium text-base text-gray-900 whitespace-nowrap dark:text-white">
                    <!--Modal de Tipos de Becas Info-->
                    <tb-modal-info v-if="showTbInfo" :tipobeca="selectedTB" @close="showTbInfo = false"/>
                    <!--Modal de Tipos de Becas Update-->
                    <tb-modal-update v-if="showTbUpda" :tipobeca="selectedTB" @close="showTbUpda = false"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
