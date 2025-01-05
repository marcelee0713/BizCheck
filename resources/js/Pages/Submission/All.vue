<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed } from 'vue';
import { Evaluation } from "@/Features/Evaluation/types/evaluation-type";

import { defineProps } from 'vue';

const props = defineProps<{
    evaluations: {
        data: Evaluation[];
        links: any;
    };
}>();

const search = ref('');
const sortOrder = ref('newest');
const showCreateModal = ref(false);
const selectedDate = ref('');

const form = useForm({
    title: '',
    description: ''
});

const filteredEvaluations = computed(() => {
    let filtered = props.evaluations.data;
    
    if (search.value) {
        filtered = filtered.filter((evaluation: Evaluation) =>
            evaluation.title.toLowerCase().includes(search.value.toLowerCase())
        );
    }
    
    if (selectedDate.value) {
        filtered = filtered.filter((evaluation: Evaluation) =>
            evaluation.created_at.startsWith(selectedDate.value)
        );
    }
    
    return sortOrder.value === 'oldest' ? [...filtered].reverse() : filtered;
});

const createEvaluation = () => {
    form.post(route('evaluations.store'), {
        onSuccess: () => {
            form.reset();
            showCreateModal.value = false;
        }
    });
};

const deleteEvaluation = (id: string) => {
    if (confirm('Are you sure you want to delete this evaluation?')) {
        form.delete(route('evaluations.destroy', id));
    }
};
</script>

<template>
    <Head title="Submissions" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#1E1E23] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center gap-4 mb-6">
                            <h2 class="text-2xl font-bold text-[#FFC82C] font-montserrat">
                                Submissions
                            </h2>
                            <h3 class="text-[#FFC82C] text-xl font-montserrat">
                                • Evaluation History
                            </h3>
                        </div>
                        <!-- Search and Sort -->
                        <div class="mb-4 flex justify-between items-center gap-4">
                            <div class="relative w-3/4">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search submissions..."
                                    class="w-full rounded-md border-[#FFC82C] dark:bg-gray-700 dark:border-[#FFC82C] pl-4 pr-10 py-2 h-[40px] text-white placeholder-gray-400"
                                />
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                            </div>
                            
                            <!-- Add this after the search input -->
                            <div class="relative">
                                <div class="relative">
                                <input
                                    v-model="selectedDate"
                                    type="date"
                                    class="w-full rounded-md border-[#FFC82C] dark:bg-gray-700 dark:border-[#FFC82C] pl-4 pr-2 py-2 h-[40px] text-white [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:mr-2"
                                />
                            </div>
                        </div>
                            <div class="relative">
                                <select
                                    v-model="sortOrder"
                                    class="appearance-none rounded-md border-[#FFC82C] bg-[#FFC82C] text-black font-montserrat px-4 py-2 pr-8 font-medium"
                                >
                                    <option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <button
                            @click="showCreateModal = true"
                            class="flex items-center gap-2 px-4 py-2 bg-[#FFC82C] text-black rounded hover:bg-[#e6b527] transition-colors font-montserrat w-fit"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create New Submission
                        </button>

                        <!-- Table for Evaluations -->
                        <div class="overflow-x-auto mt-6">
                            <table class="w-full text-left border-collapse border-spacing-0">
                                <thead class="bg-[#FFC82C] text-black font-montserrat">
                                    <tr>
                                        <th class="px-4 py-2">Submission ID</th>
                                        <th class="px-4 py-2">Created At</th>
                                        <th class="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="evaluation in filteredEvaluations" :key="evaluation.id" class="border-b border-[#FFC82C]">
                                        <td class="px-4 py-2">{{ evaluation.id }}</td>
                                        <td class="px-4 py-2">{{ evaluation.created_at }}</td>
                                        <td class="px-4 py-2 flex items-center gap-2">
                                            <button class="text-[#FFC82C] hover:text-[#e6b527]" @click="showCreateModal = true">
                                                Create Evaluation
                                            </button>
                                            <button class="text-red-500 hover:text-red-700" @click="deleteEvaluation(evaluation.id)">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-[#1E1E23] p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-medium mb-4 text-white font-montserrat">Create New Evaluation</h3>
                <form @submit.prevent="createEvaluation">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-white font-montserrat">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-700 text-white font-montserrat"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white font-montserrat">Description</label>
                            <textarea
                                v-model="form.description"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-700 text-white font-montserrat"
                            ></textarea>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button
                                type="button"
                                @click="showCreateModal = false"
                                class="px-4 py-2 text-white font-montserrat"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-[#FFC82C] text-black rounded hover:bg-[#e6b527] font-montserrat"
                                :disabled="form.processing"
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
