<script setup>
import { ref } from 'vue'

const email = ref('')

const handleSubmit = () => {
  // Handle form submission
  console.log('Submitted email:', email.value)
}
</script>

<template>
  <div class="bg-[#19191C] py-16 px-4">
    <div class="container mx-auto text-center">
      <!-- Section Title -->
      <h1 class="text-[#FF6A00] text-4xl font-bold font-montserrat mb-12">Key Features</h1>
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="text-center">
            <img 
              src="/assets/ai-powered analysis.png" 
              alt="AI Powered" 
              class="mx-auto w-[93.4px] h-[93.4px] mb-4" 
              loading="lazy" 
            />
            <h2 class="text-[#FFC82C] text-2xl font-bold font-montserrat mb-2">AI-Powered Analysis</h2>
            <p class="text-white font-montserrat">
              Leverage advanced AI to analyze your business metrics and gain valuable insights.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="text-center">
            <img 
              src="/assets/comprehensive evaluation.png" 
              alt="Evaluation" 
              class="mx-auto w-[93.4px] h-[93.4px] mb-4" 
              loading="lazy" 
            />
            <h2 class="text-[#FFC82C] text-2xl font-bold font-montserrat mb-2">Comprehensive Evaluation</h2>
            <p class="text-white font-montserrat">
              Evaluate business model efficiency, product-market fit, and customer engagement.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="text-center">
            <img 
              src="/assets/performance enhancement.png" 
              alt="Performance Enhancement" 
              class="mx-auto w-[93.4px] h-[93.4px] mb-4" 
              loading="lazy" 
            />
            <h2 class="text-[#FFC82C] text-2xl font-bold font-montserrat mb-2">Performance Enhancement</h2>
            <p class="text-white font-montserrat">
              Receive tailored suggestions to improve your business performance and operations.
            </p>
          </div>
        </div>
        <!-- Updates Form and Contact Information -->
    <div class="bg-[#19191C] py-16 px-4">
      <div class="container mx-auto">
        <div class="grid grid-cols-3 gap-8">
          <!-- First Column -->
          <div class="col-span-1">
            <h3 class="text-white font-montserrat text-base mb-4 text-start">Send me updates</h3>
            <form class="flex items-center bg-[#FFC82C] rounded-lg p-2 max-w-sm">
              <input
                type="email"
                placeholder="Your email"
                class="flex-grow text-black text-sm font-montserrat bg-transparent outline-none px-2"
              />
              <button type="submit" class="text-black font-montserrat text-lg">
                ➤
              </button>
            </form>
          </div>
        
          <!-- Second Column (Empty Space) -->
          <div class="col-span-1">
          </div>
        
          <!-- Third Column (Contact Info) -->
          <div class="col-span-1 text-start">
            <p class="text-[#FFC82C] font-montserrat text-base mb-2">Address:</p>
            <p class="text-white font-montserrat text-sm mb-4">Metro Manila, Philippines</p>
            <p class="text-[#FFC82C] font-montserrat text-base mb-2">E-mail:</p>
            <p class="text-white font-montserrat text-sm mb-4">hello@bizcheck.com</p>
            <!-- Social Icons -->
            <div class="flex justify-start space-x-2">

              <a href="#" class="text-white text-xl"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="text-white text-xl"><i class="fab fa-instagram"></i></a>
              <a href="#" class="text-white text-xl"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


