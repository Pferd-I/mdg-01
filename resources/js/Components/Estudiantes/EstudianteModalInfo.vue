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
  estudiante: Object,
});
// Estudiante Cargado
const data = ref({ padres: [], curso: {}, tipo_beca: {}, todos_padres: [] })

// Form para Agregar Ppff
const form = useForm({
    id_ppff: '',
    par: 'Tutor',
})

// Cargar Estudiante y sus Ppffs al abrir modal
async function cargarDatos() {
  const res = await fetch(route('estudiantes.get', props.estudiante.id))
  const json = await res.json()
  data.value = json.estudiante
  data.value.todos_padres = json.padres
}

// Agregar Ppff
const selectedPadre = ref(null)
watch(selectedPadre, (nuevo) => {
  form.id_ppff = nuevo ? nuevo.id : ''
});

function agregarPpff() {
  if (!form.id_ppff) return
  form.post(route('estudiantes.addPpff', {id: props.estudiante.id, par: form.par}), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      cargarDatos()
    },
  })
}

// Eliminar padre
function eliminarPpff(id_ppff) {
  if (confirm('¿Deseas quitar este padre?')) {
    router.delete(route('estudiantes.removePpff', { id_estudiante: props.estudiante.id, id_ppff }), {
      preserveScroll: true,
      onSuccess: () => cargarDatos(),
    })
  }
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
                        <h1 class="text-lg font-bold">{{ data.apellido_p }} {{ data.apellido_m }} {{ data.nombres }}</h1>
                        <h3 class="">CI: {{ data.ci}} | RUDE: {{ data.rude}} <br/>
                            Curso: <template v-if="['Inicial'].includes(estudiante.curso.nivel.nombre_nivel)">
                            {{ estudiante.curso.grado }}
                            </template>
                            <template v-else>
                                {{ estudiante.curso.grado }} de {{ estudiante.curso.nivel.nombre_nivel }}
                            </template>
                        </h3>
                        <div>
                            Beca: {{ data.tipo_beca.nombre_tipo_beca }}<br/> {{ data.tipo_beca.descripcion }}
                        </div>
                    </div>
                    <div class="p-2 border-l-2">
                        <div class="mb-5">
                            <h3 class="font-semibold pl-1 rounded-t mb-1 text-lg bg-pewter text-darkblue">Parientes:</h3>
                            <ul>
                                <li
                                    v-for="padre in data.padres"
                                    :key="padre.id"
                                    class="flex justify-between items-center border-b py-1"
                                >
                                    <span>{{ padre.nombre }} - {{ padre.pivot.parentesco}}</span>
                                    <span>
                                    <button class="mr-4" type="button" @click="verContacto(padre)"> 🕮 </button>
                                    <button type="button"  @click="eliminarPpff(padre.id)"> × </button>
                                    </span>
                                </li>
                                <li v-if="!data.padres.length" class="text-sm text-gray-500">No hay parientes registrados.</li>
                            </ul>
                        </div>
                        <label class="block text-sm font-medium mt-3">Agregar padre:</label>
                        <div><Multiselect
                            v-model="selectedPadre"
                            :options="data.todos_padres"
                            label="nombre"
                            track-by="id"
                            placeholder="Buscar o seleccionar padre..."
                            class="w-60"
                        /></div>
                        <!--<select v-model="form.id_ppff" class="border rounded px-2 py-1 w-fit text-darkblue-700">
                            <option disabled value="">Seleccionar...</option>
                            <option v-for="padre in data.todos_padres" :key="padre.id" :value="padre.id">
                                {{ padre.nombre }}
                            </option>
                        </select>-->
                        <input v-model="form.par" class="mx-1 text-darkblue-800 h-9 w-30 rounded-md" placeholder="Parentesco"/>
                        <button class="mt-2 bg-yellow p-1 rounded-sm text-darkblue-700 font-extrabold" @click="agregarPpff" :disabled="form.processing">+</button>
                    </div>
                </div>
                <modal-overlay2 v-if="showContact" @cerrar="showContact=false">
                    <modal-content2>
                        <h1 class=" font-bold text-lg">{{ ppffSelected.nombre }}</h1> <br/>
                        <table class=" rounded-sm">
                            <tr class="bg-slate-400 ">
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Número</th>
                            </tr>
                            <tr v-for="contacto in ppffSelected.contactos" :key="contacto.id">
                                <td class="px-2 border-l"> {{ contacto.tipo_contacto }} </td>
                                <td class="px-2 border-l"> {{ contacto.direccion }} </td>
                                <td class="px-2 border-x"> {{ contacto.nro_telf }}</td>
                            </tr>
                        </table>

                    </modal-content2>
                </modal-overlay2>
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
