<script setup>
import { ref, watch, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import BtnEstado from '@/Components/Subcomponents/ButtonEstado.vue';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

const emit = defineEmits(['close']);
const props = defineProps({
  plantel: Object,
});

const data = ref({ cargos: [], todos_cargos: [] })
const dataUser = ref({ usuario: null, usuarios: [] })

const formCargo = useForm({
    id_cargo: '',
})
const formUser = useForm({
    id_user: '',
})
const formPlantel = useForm({
  nombre: '',
  estado: true,
})

// Modo Edición
const modoEdicion = ref(false)
function enableNameEdit() {
  formPlantel.nombre = data.value.nombre
  modoEdicion.value = true
}
function cancelNameEdit() {
  modoEdicion.value = false
  //formPlantel.reset()
}
function deshabilitarPlantel(){
    formPlantel.estado = !formPlantel.estado;
    guardarNombre();
}
// Guardar NOmbre
function guardarNombre() {
  formPlantel.put(route('plantel.update', props.plantel.id), {
    preserveScroll: true,
    onSuccess: () => {
      data.value.nombre = formPlantel.nombre
      modoEdicion.value = false
    }
  })
}

// Funciones Usuario
const selectedUser = ref(null)
watch(selectedUser, (nuevo) => {
  formUser.id_user = nuevo ? nuevo.id : ''
});
function asignarUsuario() {
    if (!formUser.id_user) return;
    formUser.post(route('plantel.assignUsuario', props.plantel.id), {
        onSuccess: () => {
            formUser.reset();
            cargarDatos();
        }
    });
}

function eliminarUsuario() {
    if (!confirm("¿Quitar relación con este usuario?")) return;
    router.delete(route('plantel.removeUsuario', props.plantel.id), {
        onSuccess: () => cargarDatos(),
    });
}

// Funciones Cargo
const selectedCargo = ref(null)
watch(selectedCargo, (nuevo) => {
    formCargo.id_cargo = nuevo ? nuevo.id : ''
});
function agregarCargo() {
    if (!formCargo.id_cargo) return
    formCargo.post(route('plantel.addCargo', props.plantel.id), {
        preserveScroll: true,
        onSuccess: () => {
            formCargo.reset()
            cargarDatos()
        },
    })
}
function eliminarCargo(id_cargo) {
  if (confirm('¿Deseas quitar este cargo?')) {
    router.delete(route('plantel.removeCargo', { id_plantel: props.plantel.id, id_cargo }), {
      preserveScroll: true,
      onSuccess: () => cargarDatos(),
    })
  }
}

// Cargar Plantel, cargos y usuario al abrir modal
async function cargarDatos() {

    const res = await fetch(route('plantel.get', props.plantel.id))
    const json = await res.json()
    data.value = {
        ...json.plantel,
        cargos: json.plantel.cargos ?? [],
        todos_cargos: json.cargos ?? [],
    }

    const resUser = await fetch(route('plantel.getUsuario', props.plantel.id))
    const jsonUser = await resUser.json()
    dataUser.value = {
        usuario: jsonUser.usuario,
        usuarios: jsonUser.usuarios,
    }

    formPlantel.nombre = data.value.nombre;
    formPlantel.estado = data.value.estado;
}
onMounted(() => cargarDatos());
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <div class="align-content-center">
                    <div class="p-4 space-y-4">
                        <div class="flex items-center gap-3">
                            <input class="text-xl font-bold bg-transparent px-1 w-fit" id="nombre" :disabled="!modoEdicion"
                                v-model="formPlantel.nombre" />
                            <button v-if="!modoEdicion" class="bg-blue-600 text-white px-2 py-1 rounded text-sm"
                                @click="enableNameEdit"> Editar </button>
                            <button v-if="modoEdicion" class="bg-green-600 text-white px-2 py-1 rounded text-sm"
                                @click="guardarNombre" :disabled="formPlantel.processing" > Guardar </button>
                            <button v-if="modoEdicion" class="bg-gray-500 text-white px-2 py-1 rounded text-sm"
                                @click="cancelNameEdit"> Cancelar </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="mb-5 rounded-lg overflow-hidden">
                            <table class="bg-darkblue-800 text-gray-100 rounded-lg border-collapse mx-auto w-full">
                                <tr class="bg-pewter text-darkblue-800 font-bold text-lg">
                                    <th class="p-2">Cargo</th>
                                    <th class="p-2">Fecha</th>
                                    <th></th>
                                </tr>
                                <tr v-for="cargo in data.cargos" :key="cargo.id">
                                    <td class="p-2"> {{ cargo.nombre }} </td>
                                    <td class="p-2 border-x"> {{ cargo.pivot.fecha_asignacion }} </td>
                                    <td class="p-2">
                                        <button type="button"  @click="eliminarCargo(cargo.id)"> × </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <template v-if="modoEdicion" class="w-min">
                            <label class="block text-sm font-medium mt-3" for="nombre_cargo">Agregar cargo:</label>
                            <div class="flex items-center space-x-2">
                                <Multiselect
                                    v-model="selectedCargo"
                                    :options="data.todos_cargos"
                                    label="nombre"
                                    track-by="id"
                                    id="nombre_cargo"
                                    placeholder="Buscar o seleccionar cargo..."
                                    class="w-50 h-12"/>
                                <button class="bg-yellow p-1 rounded-sm text-darkblue-700 font-extrabold h-full" @click="agregarCargo" :disabled="formCargo.processing">+</button>
                            </div>
                        </template>
                        <div class="mt-8 bg-darkblue-800 p-4 rounded-lg text-pewter">
                            <h3 class="text-lg font-bold mb-3">Usuario asociado</h3>
                            <div v-if="dataUser.usuario" class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">{{ dataUser.usuario.name }}</p>
                                    <p class="text-sm">{{ dataUser.usuario.email }}</p>
                                </div>
                                <button class="ml-2 bg-red-600 text-white px-3 py-1 rounded"
                                    @click="eliminarUsuario"> Quitar Usuario </button>
                            </div>
                            <div v-else class="text-gray-300"><p>No tiene usuario asignado.</p></div>

                            <!-- Asignar usuario -->
                            <div v-if="!dataUser.usuario" class="mt-4">
                                <label class="block text-sm mb-1 font-semibold">Asignar usuario:</label>
                                <Multiselect
                                    placeholder="Seleccionar usuario" label="name" track-by="id"
                                    v-model="selectedUser" :options="dataUser.usuarios"
                                    :multiple="false" :close-on-select="true"
                                />
                                <button class="mt-2 bg-green-600 text-white px-4 py-1 rounded" :disabled="formUser.processing"
                                    @click="asignarUsuario"> Guardar Usuario </button>
                            </div>
                        </div>

                        <div class="mt-5 flex items-center">
                            <span class="font-bold text-lg text-pewter mr-3">Estado del miembro:</span>
                            <BtnEstado :estado="formPlantel.estado" @click="deshabilitarPlantel"/></div>
                    </div>
                </div>
            </template>
        </modal-content>
    </modal-overlay>

</template>
<style scoped>
</style>
