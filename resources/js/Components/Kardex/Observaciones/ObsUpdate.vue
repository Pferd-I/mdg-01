<script setup>
import { onMounted, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalFormOverfVis.vue'
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import BtnDelete from '@/Components/Aulas/SubComponentes/btnDelete.vue';
import BtnUndo from '@/Components/Aulas/SubComponentes/btnUndoDel.vue';
import InputError from '@/Components/InputError.vue';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import { usePermission } from '@/composables/permissions'

const { hasRole, hasRoles } = usePermission();
const props = defineProps({
    observacion: Object,
    estudiantes: Array,
    plantel: Array,
    cursos: Array,
    asignaturas: Object,
    tipos_observacion: Array,
    mi_plantel: Object,
});

const emit = defineEmits(['close', 'saved']);

const form = useForm({
    id_plantel: props.observacion.id_plantel || '',
    id_estudiante: props.observacion.id_estudiante || '',
    tipo: props.observacion.tipo || '',
    descripcion: props.observacion.descripcion || '',
    id_curso: props.observacion.id_curso || '',
    asignatura: props.observacion.asignatura || '',
    //fecha_evento: props.observacion.fecha_evento ? props.observacion.fecha_evento.split('-').reverse().join('-') : new Date().toISOString().split('T')[0],
    fecha_evento: formatToInputDate(props.observacion.fecha_evento) || new Date().toISOString().split('T')[0],
});
// Selección de miembro del plantel
const selectedPlantel = ref(props.plantel.find(p => p.id === props.observacion.id_plantel) || null);
watch(selectedPlantel, (nuevo) => {
    form.id_plantel = nuevo ? nuevo.id : '';
});
//Seleccionar Estudiante
const selectedEst = ref(props.estudiantes.find(est => est.id === props.observacion.id_estudiante) || null);
watch(selectedEst, (nuevo) => {
  form.id_estudiante = nuevo ? nuevo.id : ''
});

//Seleccionar Curso
const selectedCur = ref(props.cursos.find(curso => curso.id === props.observacion.id_curso) || null);
watch(selectedCur, (nuevo) => {
  form.id_curso = nuevo ? nuevo.id : ''
});

//Seleccionar Curso según estudiante
watch(selectedEst, (estudianteSeleccionado) => {
    if (estudianteSeleccionado && estudianteSeleccionado.id_curso) {
        const cursoEncontrado = props.cursos.find(curso => curso.id === estudianteSeleccionado.id_curso);
        if (cursoEncontrado) {
            selectedCur.value = cursoEncontrado;
            form.id_curso = cursoEncontrado.id;
        } else {
            selectedCur.value = null;
            form.id_curso = '';
        }
    } else {
        selectedCur.value = null;
        form.id_curso = '';
    }
});

//Fecha
const fechaFuturaError = ref('');
function formatToInputDate(dateString) {
    if (!dateString) return '';
    if (dateString.includes('-') && dateString.length === 10 && dateString[4] === '-') {
        return dateString;
    }
    const parts = dateString.split('-');
    if (parts.length === 3) {
        const day = parts[0].padStart(2, '0');
        const month = parts[1].padStart(2, '0');
        const year = parts[2];
        return `${year}-${month}-${day}`;
    }
    return '';
}
watch(() => form.fecha_evento, (nuevaFecha) => {
    if (nuevaFecha) {
        const fechaSeleccionada = new Date(nuevaFecha);
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        fechaSeleccionada.setHours(0, 0, 0, 0);

        if (fechaSeleccionada > hoy) { fechaFuturaError.value = 'La fecha no puede ser futura.';
        } else { fechaFuturaError.value = ''; }
    } else {
        fechaFuturaError.value = '';
    }
});

function actualizarObs() {
    form.put(route('observaciones.update', props.observacion.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('saved');
            emit('close');
        },
        onError: (errors) => {
            console.error('Errores de validación:', errors);
        }
    });
}
function OnOff() {
    form.put(route('observaciones.onoff', props.observacion.id), {
        onSuccess: () => emit('close')
    })
}
onMounted(() => {
    /*if (props.plantel.length > 0) {
        form.tipo = props.tipos_observacion[0];
    }
    if (props.mi_plantel) {
        selectedPlantel.value = props.mi_plantel;
        form.id_plantel = props.mi_plantel.id;
    } else {
        selectedPlantel.value = null;
    }*/
});
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="actualizarObs">
                    <div class="flex">
                        <!-- Selección de tipo-->
                        <select id="tipo" class="inputs mb-4 w-50 rounded-md" v-model="form.tipo">
                            <option v-for="tipo in tipos_observacion" :key="tipo" :value="tipo">
                                {{ tipo }}
                            </option>
                        </select>
                        <InputError :message="form.errors.tipo" />
                        <!-- Fecha del evento -->
                        <div class="ml-2">
                            <input id="fecha_evento" class="w-full border rounded px-3 py-2" type="date" @input="fechaFuturaError = ''"
                                v-model="form.fecha_evento" :max="new Date().toISOString().split('T')[0]" :class="{ 'border-red-500': fechaFuturaError }"/>
                            <div v-if="fechaFuturaError" class="text-red-500 text-sm mt-1">
                                {{ fechaFuturaError }}
                            </div>
                            <InputError :message="form.errors.fecha_evento" />
                        </div>
                        <!-- Selección de docente -->
                        <div class="mb-4 w-80 flex ml-4" >
                            <label for="id_plantel" class="text-lg font-bold text-pewter my-auto mr-1">Docente: </label>
                            <Multiselect id="id_plantel" v-if="hasRole('admin')" class="text-darkblue-800 w-60" track-by="id" label="nombre"
                                v-model="selectedPlantel" placeholder="Seleccionar docente"
                                :options="plantel" :searchable="true" :allow-empty="false"/>
                            <Multiselect id="id_plantel" v-else class="text-darkblue-800 w-60" track-by="id" label="nombre"
                                v-model="selectedPlantel" placeholder="Seleccionar docente"
                                :options="plantel" :searchable="true" :allow-empty="false" :disabled="!!props.mi_plantel"/>
                            <InputError :message="form.errors.id_plantel" />
                        </div>
                    </div>
                    <div class="flex">
                        <!-- Selección de estudiante -->
                        <div class="mb-4 w-80 flex">
                            <label for="id_estudiante" class="text-lg font-bold text-pewter my-auto mr-1">Estudiante: </label>
                            <Multiselect id="id_estudiante" class="text-darkblue-800 w-60" track-by="id" label="nombres" placeholder="Seleccionar estudiante"
                                v-model="selectedEst" :options="estudiantes" :searchable="true" :allow-empty="false">
                                <template #option="{ option }">
                                    {{ option.apellido_p }} {{ option.apellido_m }} {{ option.nombres}}
                                </template>
                                <template #singleLabel="{ option }">
                                    {{ option.apellido_p }} {{ option.apellido_m }} {{ option.nombres}}
                                </template>
                            </Multiselect>
                            <InputError :message="form.errors.id_estudiante" />
                        </div>
                        <!-- Selección de curso -->
                        <div class="mb-4 w-48 flex ml-4">
                            <Multiselect id="curso" class="text-darkblue-800" track-by="id" label="nombre" placeholder="Seleccionar curso"
                                v-model="selectedCur" :options="cursos" :searchable="true" :allow-empty="false">
                                <template #option="{ option }">
                                    <template v-if="['Inicial'].includes(option.nivel.nombre_nivel)">
                                        {{ option.nro_grado }} '{{ option.paralelo.nombre_paralelo}}'
                                    </template>
                                    <template v-else>{{ option.nro_grado }}º de {{ option.nivel.nombre_nivel }} '{{ option.paralelo.nombre_paralelo}}'</template>
                                </template>
                                    <template #singleLabel="{ option }">
                                        <template v-if="['Inicial'].includes(option.nivel.nombre_nivel)">
                                            {{ option.nro_grado }} '{{ option.paralelo.nombre_paralelo}}'
                                        </template>
                                        <template v-else>{{ option.nro_grado }}º de {{ option.nivel.nombre_nivel }} '{{ option.paralelo.nombre_paralelo}}'</template>
                                    </template>
                            </Multiselect>
                            <InputError :message="form.errors.id_curso" />
                        </div>
                        <!-- Selección de asignatura -->
                        <div class="mb-4 w-48 flex ml-4">
                            <select id="asignatura" class="inputs mb-4 w-50 rounded-md" v-model="form.asignatura">
                                <option v-for="asig in asignaturas" :key="asig" :value="asig">
                                    {{ asig }}
                                </option>
                            </select>
                            <InputError :message="form.errors.asignatura" />
                        </div>
                    </div>
                    <div class="flex">
                        <!-- Descripción -->
                        <div class="w-full">
                            <textarea class="inputs w-full h-32 rounded-md" v-model="form.descripcion" placeholder="Escribe la descripción de la observación aquí..." name="descripcion"></textarea>
                            <InputError :message="form.errors.descripcion" />
                        </div>
                    </div>
                    <template v-if="observacion.estado" >
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Actualizar Observación
                        </PrimaryButton>
                        <BtnDelete :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="OnOff"/>
                    </template>
                    <template v-else>
                        <BtnUndo :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="OnOff"/>
                    </template>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
