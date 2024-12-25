<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const navConfig = {
  brandName: {
    first: 'BIZ',
    second: 'CHECK'
  },
  buttonText: 'Get Started',
  loginRoute: 'login'
}
</script>

<template>
  <nav aria-label="Main Navigation" class="bg-[#1E1E23] py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
      <div class="font-bold text-lg font-montserrat">
        <span class="text-primary-yellow">{{ navConfig.brandName.first }}</span>
        <span class="text-white">{{ navConfig.brandName.second }}</span>
      </div>
      
      <div>
        <Link 
          :href="route(navConfig.loginRoute)"
          class="bg-[#FFC82C] text-black px-4 py-2 rounded-lg font-montserrat hover:bg-yellow-500 transition-all duration-300"
          :aria-label="`${navConfig.buttonText} - Login to BizCheck`"
        >
          {{ navConfig.buttonText }}
        </Link>
      </div>
    </div>
  </nav>
</template>
