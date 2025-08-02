<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';

const props = defineProps({
    'tipobeca':Object,
})
const emit = defineEmits(['close',]);
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                Beca: {{ tipobeca.nombre_tipo_beca }} <br/>
                Descripción: {{ tipobeca?.descripcion }} <br/>
                Descuento: {{ tipobeca?.dcto}}% de dcto.
            </template>
        </modal-content>
    </modal-overlay>
</template>
