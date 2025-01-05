<script setup lang="ts">
import { ref, onMounted, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";
import userPfp from "../../../public/images/profile.png";

const navConfig = {
    brandName: {
        first: "BIZ",
        second: "CHECK",
    },
    buttonText: "Get Started",
    loginRoute: "login",
    submissionRoute: "evaluations",
    profileRoute: "profile",
    businessRoute: "business",
    logoutRoute: "logout",
};

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = (event: MouseEvent) => {
    const dropdown = document.querySelector(".relative");
    if (dropdown && !dropdown.contains(event.target as Node)) {
        isDropdownOpen.value = false;
    }
};

const logout = () => {
    router.post(route(navConfig.logoutRoute));
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>
<template>
    <div class="flex flex-col w-full h-full" @click.stop>
        <div class="w-full h-[55px] bg-secondary flex-shrink-0 z-10">
            <div
                class="flex justify-between items-center w-full h-full mx-auto container px-4"
            >
                <Link
                    :href="route('dashboard')"
                    class="font-extrabold text-2xl font-montserrat"
                >
                    {{ navConfig.brandName.first
                    }}<span class="text-textColor">{{
                        navConfig.brandName.second
                    }}</span>
                </Link>
                <div class="flex items-center gap-6">
                    <Link
                        :href="route(navConfig.submissionRoute)"
                        class="text-white font-montserrat hover:text-yellow-500 transition-all duration-300"
                    >
                        Submission
                    </Link>

                    <div class="relative">
                        <button
                            class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden border border-gray-500 hover:scale-105 transition-all duration-300"
                            :aria-label="`Profile Menu`"
                            @click.stop="toggleDropdown"
                        >
                            <img
                                :src="$page.props.auth.user.avatar ?? userPfp"
                                alt="Profile"
                                class="w-full h-full object-cover"
                            />
                        </button>

                        <div
                            v-if="isDropdownOpen"
                            class="absolute right-0 mt-2 w-40 bg-secondary text-white rounded-lg shadow-lg z-20"
                        >
                            <div
                                class="px-4 py-2 font-bold text-yellow-500 font-montserrat"
                            >
                                My Account
                            </div>
                            <hr class="border-gray-600" />
                            <Link
                                :href="route(navConfig.profileRoute)"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-background transition-all duration-300 font-montserrat"
                            >
                                Profile
                            </Link>

                            <Link
                                :href="route(navConfig.businessRoute)"
                                class="block px-4 py-2 hover:bg-yellow-500 hover:text-background transition-all duration-300 font-montserrat"
                            >
                                Business
                            </Link>

                            <button
                                @click="logout"
                                class="w-full text-left block px-4 py-2 hover:bg-yellow-500 hover:text-background transition-all duration-300 font-montserrat"
                            >
                                Log out
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <slot />
    </div>
</template>
