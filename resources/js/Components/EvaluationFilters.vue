<script setup>
defineProps(['search', 'selectedDate', 'sortOrder'])
defineEmits(['update:search', 'update:selectedDate', 'update:sortOrder'])
</script>

<template>
  <div class="mb-4 flex justify-between items-center gap-4">
    <div class="relative w-3/4">
      <input
        :value="search"
        @input="$emit('update:search', $event.target.value)"
        type="text"
        placeholder="Search submissions..."
        class="w-full rounded-md border-[#FFC82C] dark:bg-gray-700 dark:border-[#FFC82C] pl-4 pr-10 py-2 h-[40px] text-white placeholder-gray-400"
      />
    </div>
    
    <div class="relative">
      <input
        :value="selectedDate"
        @input="$emit('update:selectedDate', $event.target.value)"
        type="date"
        class="w-full rounded-md border-[#FFC82C] dark:bg-gray-700 dark:border-[#FFC82C] pl-4 pr-2 py-2 h-[40px] text-white [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:mr-2"
      />
    </div>

    <div class="relative">
      <select
        :value="sortOrder"
        @change="$emit('update:sortOrder', $event.target.value)"
        class="appearance-none rounded-md border-[#FFC82C] bg-[#FFC82C] text-black font-montserrat px-4 py-2 pr-8 font-medium"
      >
        <option value="newest">Newest</option>
        <option value="oldest">Oldest</option>
      </select>
      <!-- Sort icon -->
    </div>
  </div>
</template>
