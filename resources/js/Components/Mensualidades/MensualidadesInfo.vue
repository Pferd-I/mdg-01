<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';

const emit = defineEmits(['close',]);
const props = defineProps({
  gestion: Object,
  mensualidades: Array,
});
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <Table class="overflow-hidden">
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>Nro.</TableHeaderCell>
                            <TableHeaderCell>Mensualidades</TableHeaderCell>
                            <TableHeaderCell>Monto</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="m in mensualidades" :key="mensualidades.id" class="border-t">
                            <TableDataCell class="max-w-56 overflow-hidden">{{m.nro_mes}}</TableDataCell>
                            <TableDataCell class="max-w-56 overflow-hidden">{{m.nombre_mes}}</TableDataCell>
                            <TableDataCell class="max-w-56 overflow-hidden">{{m.monto}}</TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </template>
        </modal-content>
    </modal-overlay>
</template>
