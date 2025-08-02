<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ButtonX from '@/Components/Subcomponents/ModalOberlayXButton.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';

const props = defineProps({
    niveles: Array,
    paralelos: Array,
});
const emit = defineEmits(['close']);
const form = useForm({
    id: '',
    grado: '',
    nro_grado: '',
    id_nivel: 1,
    id_paralelo: 1,
    gestion: new Date().getFullYear(),
    estado: Boolean,
});
function crearCurso(){
    form.post(route('cursos.store'),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al crear el curso.");
        }
      });
};
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="crearCurso">
                    <input class="w-32" id="grado" type="text" v-model="form.grado" placeholder="Curso">
                    <input class="ml-1 w-16" id="nro_grado" type="text" v-model="form.nro_grado" placeholder="Nro">
                    <div class="mt-3 w-fit font-bold text-pewter flex">
                        <div class="mb-1"><label for="nombre_paralelo">Paralelo: </label>
                            <select id="nombre_paralelo" v-model="form.id_paralelo" class="text-slate-900">
                                <option v-for="p in paralelos" :value="p.id">
                                    <p v-if="p.estado">{{ p.nombre_paralelo }}</p>
                                </option>
                            </select>
                        </div>

                        <div class="ml-2 mb-1"><label for="nombre_nivel">Nivel: </label>
                        <select id="nombre_nivel" v-model="form.id_nivel" class="text-slate-900">
                            <option v-for="N in niveles" :value="N.id">
                                <p v-if="N.estado == 1" >{{ N.nombre_nivel }}</p>
                            </option>
                        </select></div>
                    </div>
                        <label class="text-pewter" for="gestion">Gestión: </label>
                        <input class="w-32" id="gestion" type="number" v-model="form.gestion" placeholder="Gestión">
                    <PrimaryButton class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
