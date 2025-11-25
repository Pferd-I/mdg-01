<script setup>
import { ref, watch, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalOverlay2 from '@/Components/Subcomponents/ModalOverlay-02.vue';
import ModalContent2 from '@/Components/Subcomponents/ModalContent-02.vue';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

const emit = defineEmits(['close']);
const props = defineProps({
  ppff: Object,
});
// Ppff Cargado
const data = ref({ contactos: [], todos_estudiantes: [] })


// Cargar Ppff y sus Estudiantes al abrir modal
async function cargarDatos() {
  const res = await fetch(route('ppffs.get', props.ppff.id))
  const json = await res.json()
  data.value = json.ppff
  data.value.todos_estudiantes = json.estudiantes
}

//Ver Contactos de Ppff
const ppffSelected = ref(null);
const showContact = ref(false);
function verContacto(ppff){
    ppffSelected.value = ppff;
    showContact.value = true;
}

onMounted(() => cargarDatos());
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <div class="flex">
                    <div class="p-4 space-y-4">
                        <h1 class="text-lg font-bold">{{ data.nombre }}</h1>
                        <h3 class="">CI/NIT: {{ data.cionit}}<br/></h3>
                    </div>
                    <div class="p-2 border-l-2">
                        <div class="mb-5">
                            <table class="bg-darkblue-800 text-gray-100 rounded-lg border-collapse">
                                <tr class="bg-pewter text-darkblue-800 font-bold text-lg">
                                    <th class="p-2">Contacto</th>
                                    <th class="p-2">Dirección</th>
                                    <th class="p-2">Número</th>
                                </tr>
                                <tr v-for="contacto in data.contactos" :key="contacto.id">
                                    <td class="p-2"> {{ contacto.tipo_contacto }} </td>
                                    <td class="p-2 border-x"> {{ contacto.direccion }} </td>
                                    <td class="p-2"> {{ contacto.nro_telf }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </modal-content>
    </modal-overlay>

</template>
<style scoped>
</style>
