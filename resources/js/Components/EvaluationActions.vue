<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['evaluation'])

const deleteEvaluation = (id) => {
  if (confirm('Are you sure you want to delete this submission?')) {
    useForm({}).delete(route('evaluations.destroy', id))
  }
}
</script>

<template>
  <div class="flex items-center gap-2">
    <button 
      class="text-blue-400 hover:text-blue-600"
      @click="$inertia.visit(`/evaluation/${evaluation.id}`)"
    >
      View
    </button>
    
    <button
      @click="$inertia.visit('/submission')"
    >
      Create Evaluation
    </button>

    <button 
      class="text-red-500 hover:text-red-700" 
      @click="deleteEvaluation(evaluation.id)"
    >
      Delete
    </button>
  </div>
</template>
