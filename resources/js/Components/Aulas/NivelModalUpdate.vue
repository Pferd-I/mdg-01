<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/SecondaryButtonModal.vue';
const props = defineProps({
    nivel: Object,
});
const emit = defineEmits(['close']);

const form = useForm({
    id: props.nivel?.id,
    nombre_nivel: props.nivel?.nombre_nivel,
    estado: props.nivel?.estado,
});

function guardarNivel(){
    form.put(route('nivels.update', form.id),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el nivel.");
        }
      });
};
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content class=" text-pewter">
            <template #default>
                <modal-form @submit.prevent="guardarNivel">
                    <input id="nombre_nivel" type="text" v-model="form.nombre_nivel">
                    <div class="w-fit font-bold text-pewter">
                        <div v-if="form.estado" class="bg-green-800">
                            <p class="m-2">Activo</p>
                        </div>
                        <div v-else class=" bg-red-800">
                            <p class="m-2">Inactivo</p>
                        </div>
                    </div>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
