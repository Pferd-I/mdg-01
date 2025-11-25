<script setup>
import {ref, watch} from 'vue';
import { Head, Link, useForm, router} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ButtonContact from '@/Components/Subcomponents/ButtonContact.vue';
import Info from '@/Components/Subcomponents/ButtonInfo.vue';
import PlanInfo from '@/Components/Plantel/PlantelInfo.vue';

defineProps(['plantel', 'cargos']);

//Mostrar detalles del cargo
const selectedCargo = ref(null);
const C_showInfo = ref(false);
function showCargo(cargo){
    C_showInfo.value = true;
    selectedCargo.value = cargo;
}
//Mostrar detalles del plantel
const selectedPlantel = ref(null);
const P_showInfo = ref(false);
function showPlantel(cargo){
    P_showInfo.value = true;
    selectedPlantel.value = cargo;
}
</script>

<template>
    <Head title="Plantel" />
    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  flex-wrap flex">
                <!--Tabla Cargos-->
                <div class="p-3 bg-slate-600 w-auto rounded-md h-fit">
                    <div class="bg-darkblue-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="mt-6">
                            <Table>
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell></TableHeaderCell>
                                        <TableHeaderCell>Nombre</TableHeaderCell>
                                        <TableHeaderCell></TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow v-for="(c, index) in cargos" :key="c.id" class="border-t">
                                        <TableDataCell>{{index + 1}}</TableDataCell>
                                        <TableDataCell>{{c.nombre}}</TableDataCell>
                                        <TableDataCell>
                                            <!--<Modal :show="showConfirmDelPpff" @close="closeModal">
                                                <div class="p-6">
                                                    <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar al miembro del plantel?</h2>
                                                    <div class="mt-6 flex space-x-4">
                                                        <DangerButton @click="$event=>deletePpff(p.id)">Eliminar</DangerButton>
                                                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                    </div>
                                                </div>
                                            </Modal>-->
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
                <!--Tabla Plantel-->
                <div class="ml-5 p-3 bg-slate-600 w-auto rounded-md">
                    <div class="bg-darkblue-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="mt-6">
                            <Table>
                                <template #header>
                                    <TableRow>
                                        <TableHeaderCell></TableHeaderCell>
                                        <TableHeaderCell>Nombre</TableHeaderCell>
                                        <TableHeaderCell></TableHeaderCell>
                                    </TableRow>
                                </template>
                                <template #default>
                                    <TableRow v-for="(p, index) in plantel" :key="p.id" class="border-t">
                                        <TableDataCell>{{index}}</TableDataCell>
                                        <TableDataCell>{{p.nombre}}</TableDataCell>
                                        <TableDataCell>
                                            <Info @click="showPlantel(p)"/>
                                            <!--<ButtonContact @click="showContacto(ppff)"/>
                                            <Modal :show="showConfirmDelPpff" @close="closeModal">
                                                <div class="p-6">
                                                    <h2 class="text-lg font-semibold text-slate-100">¿Está seguro de eliminar al miembro del plantel?</h2>
                                                    <div class="mt-6 flex space-x-4">
                                                        <DangerButton @click="$event=>deletePpff(p.id)">Eliminar</DangerButton>
                                                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                    </div>
                                                </div>
                                            </Modal>-->
                                        </TableDataCell>
                                    </TableRow>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
                <div class="font-medium text-base text-gray-900 whitespace-nowrap dark:text-white">
                    <PlanInfo v-if="P_showInfo && selectedPlantel" @close="P_showInfo = false"
                        :plantel="selectedPlantel"/>

                </div>
            </div>
        </div>
    </AdminLayout>
</template>
