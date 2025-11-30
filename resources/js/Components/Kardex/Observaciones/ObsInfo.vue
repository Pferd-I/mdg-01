<script setup>
import { ref, watch, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';

const emit = defineEmits(['close']);
const props = defineProps({
  observacion: Object,
});
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <div class="flex">
                    <div class="p-4 space-y-4">
                        <h2 class="text-2xl font-bold mb-4">Detalles de la Observación</h2>
                        <div class="flex">
                            <div class="w-80">
                                <strong>Docente: </strong>
                                <span> {{observacion.plantel.nombre}}</span>
                            </div>
                            <div>
                                <span> {{observacion.fecha_evento}}</span>
                            </div>
                        </div>
                        <div>
                            <strong>Estudiante: </strong>
                            <span>{{ observacion.estudiante.apellido_p}} {{ observacion.estudiante.apellido_m}} {{ observacion.estudiante.nombres}}</span>
                        </div>
                        <div class=" bg-darkblue-700 p-1 rounded-sm">
                            <div class=" bg-darkblue-800 p-2 rounded-sm">
                                <strong>Asunto: </strong>
                                <span>{{observacion.tipo}}</span><br/>
                                <p class="whitespace-pre-wrap border-t-2 mt-2 pt-2">{{observacion.descripcion}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </template>
        </modal-content>
    </modal-overlay>

</template>
<style scoped>
  .modal-overla {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
</style>
