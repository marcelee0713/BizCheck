<script setup>
defineProps(['evaluations'])
</script>

<template>
  <table class="w-full text-left border-collapse border-spacing-0">
    <thead class="bg-[#FFC82C] text-black font-montserrat">
      <tr>
        <th class="px-4 py-2">Title</th>
        <th class="px-4 py-2">Date</th>
        <th class="px-4 py-2">Time</th>
        <th class="px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="evaluation in evaluations" :key="evaluation.id" class="border-b border-[#FFC82C]">
        <td class="px-4 py-2">{{ evaluation.business_name }}</td>
        <td class="px-4 py-2">{{ new Date(evaluation.created_at).toLocaleDateString('en-PH', { timeZone: 'Asia/Manila', year: 'numeric', month: 'long', day: 'numeric' }) }}</td>
        <td class="px-4 py-2">{{ new Date(evaluation.created_at).toLocaleTimeString('en-PH', { timeZone: 'Asia/Manila', hour: '2-digit', minute: '2-digit', second: '2-digit' }) }}</td>
        <td class="px-4 py-2">
          <EvaluationActions :evaluation="evaluation" />
        </td>
      </tr>
    </tbody>
  </table>
</template>
