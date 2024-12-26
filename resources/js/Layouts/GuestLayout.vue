<script setup lang="ts">
const navConfig = {
    brandName: {
        first: "BIZ",
        second: "CHECK",
    },
    buttonText: "Get Started",
    loginRoute: "login",
};
</script>

<template>
    <div class="flex flex-col w-full h-full">
        <!-- Navbar -->
        <div class="w-full h-[55px] bg-secondary flex-shrink-0 z-10">
            <div class="flex justify-between items-center w-full h-full mx-auto container px-4 sm:px-6 md:px-8">
                <!-- Brand Name -->
                <Link
                    :href="route('dashboard')"
                    class="font-extrabold text-2xl font-montserrat"
                >
                    {{ navConfig.brandName.first }}<span class="text-textColor">{{ navConfig.brandName.second }}</span>
                </Link>

                <!-- Login Button -->
                <Link
                    :href="route(navConfig.loginRoute)"
                    class="bg-primary text-background px-3 py-1 rounded-lg font-montserrat hover:bg-yellow-500 transition-all duration-300 sm:px-4 md:px-5"
                    :aria-label="`${navConfig.buttonText} - Login to BizCheck`"
                >
                    {{ navConfig.buttonText }}
                </Link>
            </div>
        </div>

        <!-- Slot -->
        <slot />
    </div>
</template>

