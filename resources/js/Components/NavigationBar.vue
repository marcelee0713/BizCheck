<script setup>
defineEmits(['get-started'])
</script>

<template>
  <nav class="bg-[#1E1E23] py-4">
    <div class="container mx-auto flex justify-between items-center">
      <div class="font-bold text-lg font-montserrat">
        <span class="text-primary-yellow">BIZ</span>
        <span class="text-white">CHECK</span>
      </div>
      <button 
        @click="$emit('get-started')"
        class="bg-[#FFC82C] text-black px-4 py-2 rounded-lg font-montserrat hover:bg-yellow-500 transition-all duration-300"
      >
        Get Started
      </button>
    </div>
  </nav>
</template>
