<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { Head } from "@inertiajs/vue3"
import { ref } from 'vue'
import { useEvaluationFilters } from '@/Features/Evaluation/composables/useEvaluationFilters'
import EvaluationFilters from '@/Components/EvaluationFilters.vue'
import EvaluationTable from '@/Components/EvaluationTable.vue'
import { defineProps } from 'vue'

const props = defineProps(['evaluations'])
const search = ref('')
const sortOrder = ref('newest')
const selectedDate = ref('')

const filteredEvaluations = useEvaluationFilters(
    props.evaluations.data,
    search,
    selectedDate,
    sortOrder
)
</script>

<template>
    <Head title="Submissions" />
    <AuthenticatedLayout>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-[#1E1E23] overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="flex items-center gap-4 mb-6">
                <h2 class="text-2xl font-bold text-[#FFC82C] font-montserrat">Submissions</h2>
                <h3 class="text-[#FFC82C] text-xl font-montserrat">• Evaluation History</h3>
              </div>
            
              <EvaluationFilters
                v-model:search="search"
                v-model:selectedDate="selectedDate"
                v-model:sortOrder="sortOrder"
              />

              <button
                @click="$inertia.visit('/submission')"
                class="flex items-center gap-2 px-4 py-2 bg-[#FFC82C] text-black rounded hover:bg-[#e6b527] transition-colors font-montserrat w-fit"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New Submission
              </button>

              <div class="overflow-x-auto mt-6">
                <EvaluationTable :evaluations="filteredEvaluations" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
</template>
