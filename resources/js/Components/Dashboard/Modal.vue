<!-- Modal.vue -->
<template>
    <div v-if="isOpen" class="modal-overlay z-40" @click.self="close">
        <div class="p-1 bg-darkblue rounded-md">
            <div class="p-1 bg-pewter rounded-md">
                <div class="modal-content p-4 w-auto h-96 bg-darkblue text-slate-100">
                  <h2 class="font-extrabold text-3xl mb-2">{{ post?.title }}</h2>
                  <p><strong  class="font-extrabold text-xl mb-1"> {{ post?.subtitle }}</strong></p>
                  <p class=" text-pretty text-lg">{{ post?.content }}</p>
                  <!--<button @click="close">Cerrar</button>-->
                </div>
            </div>
        </div>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  defineProps({
    isOpen: Boolean,
    post: Object
  });

  const emit = defineEmits(['close']);

  const close = () => {
    emit('close');
  };
  </script>

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
