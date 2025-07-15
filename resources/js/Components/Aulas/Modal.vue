<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '../TextInput.vue';
import PrimaryButtonL from '@/Components/PrimaryButtonLightContainer.vue';
import { onMounted, watch } from 'vue';

const props = defineProps({
    nivel: {
        type: Object,
        required: true,
    },
    isOpen: Boolean,
});

const form= useForm({
    nombre_nivel: props.nivel?.nombre_nivel,
    estado: props.nivel?.estado,
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
  };
watch(
    () => props.nivel,
);
</script>
<!-- Modal.vue -->
<template>
    <div v-if="isOpen" class="modal-overlay z-40" @click.self="close">
        <div class="p-1 bg-darkblue rounded-md w-1/3">
            <div class="p-1 bg-pewter rounded-md">
                <div class="modal-content p-4 w-auto h-1/5 bg-darkblue text-pewter">
                    <form @submit.prevent="form.put(route('aulas.index'))">
                        <div class="py-2">
                            <InputLabel id="Nombre" for="nombre_nivel" value="Nombre:" class="text-xl" />
                            <TextInput id="nombre_nivel" type="text" class="mt-1 block w-2/5 text-2xl" v-model="form.nombre_nivel"/>
                        </div>
                        <div class="py-2 flex-wrap">
                            <InputLabel id="Estado" for="estado" value="Estado:" class="w-min text-xl" />
                            <p class="w-min">
                            <InputLabel id="estado" v-if="form.estado = 1" value="Activo" class="text-xl bg-lime-600 p-2 w-min h-min rounded-md" />
                            <InputLabel id="estado" v-else value="Inactivo" class="text-xl bg-red-700 p-2 w-min h-min rounded-md" />
                            </p>
                        </div>
                        <div class="mt-4">
                            <PrimaryButtonL class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Actualizar
                            </PrimaryButtonL>
                            <PrimaryButtonL class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Eliminar
                            </PrimaryButtonL>
                        </div>
                    </form>
                  <!--<button @click="close">Cerrar</button>-->
                </div>
            </div>
        </div>
    </div>
  </template>



  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  </style>
