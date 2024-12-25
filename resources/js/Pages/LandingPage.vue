<script setup>
import { Link } from '@inertiajs/vue3'
import BenefitCard from "@/Components/BenefitCard.vue";
import KeyFeaturesSection from "@/Components/KeyFeaturesSection.vue";
import NavigationBar from "@/Components/NavigationBar.vue";
import { benefits } from "@/constants/benefits";
</script>

<template>
    <div>
        <NavigationBar />
        <!-- First Page Section -->
        <div
            class="landing-page min-h-screen flex flex-col items-center justify-center bg-[#19191C] text-yellow-400"
        >
            <div
                class="container mx-auto flex flex-col md:flex-row lg:flex-row items-center space-y-8 md:space-y-0 md:space-x-8 px-4"
            >
                <div
                    class="text-content md:w-1/2 lg:w-1/2 text-center md:text-left"
                >
                    <h1 class="text-5xl font-bold mb-4 font-montserrat">
                        <span class="text-primary-yellow">BIZ</span>
                        <span class="text-white">CHECK</span><br />
                        <span class="text-white text-4xl font-bold"
                            >AI-Powered Business Insights</span
                        >
                    </h1>
                    <p class="text-lg mb-8 text-white font-montserrat leading-relaxed pb-8">Optimize your business strategies and grow efficiently<br>
                    with actionable, AI-powered insights.
                    </p>
                    <div class="mt-6">
                        <Link
                            :href="route('login')"
                            class="bg-[#FFC82C] text-black px-6 py-3 rounded-lg font-montserrat hover:bg-yellow-500 transition-all duration-300"
                        >
                            Try BizCheck Now
                        </Link>
                    </div>
                </div>

                <div
                    class="image-content w-full md:w-2/6 flex justify-center"
                >
                    <picture>
                        <source
                            srcset="/assets/landingpage.png"
                            type="image/webp"
                        />
                        <img
                            :src="'/assets/landingpage.png'"
                            alt="BizCheck Illustration"
                            class="w-full max-w-md md:max-w-lg lg:max-w-xl h-auto object-contain"
                            loading="lazy"
                        />
                    </picture>
                </div>
            </div>
        </div>
        <!-- Benefits Section -->
        <div
        class="min-h-screen bg-[#1E1E23] flex items-center justify-center p-8"
        >
        <div class="w-full max-w-6xl text-center space-y-8">
            <h1 class="text-[FFC72E] text-4xl font-bold font-montserrat">
            Benefits
            </h1>
            <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 text-start sm:text-center"
            >
            <BenefitCard
                :title="benefits.boomTech.title"
                :items="benefits.boomTech.items"
            />
            <BenefitCard
                :title="benefits.partners.title"
                :items="benefits.partners.items"
            />
            </div>
        </div>
        </div>
        <KeyFeaturesSection />
        <footer
            class="bg-[#1E1E23] text-white py-4 text-center font-montserrat text-sm"
        >
            All rights reserved. © 2024 BIZCHECK.
            <a href="#" class="text-primary-yellow">Privacy Policy.</a>
        </footer>
    </div>
</template>
