<script setup lang="ts">
import { ref } from "vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

const model = defineModel<string | undefined>();

const isVisible = ref<boolean>(false);

defineProps<{
    label?: string;
    id?: string;
    err?: string;
    type?: string;
    autofocus?: boolean;
    required?: boolean;
    disabled?: boolean;
    onChange?: (event: Event) => void;
}>();

const toggle = () => {
    isVisible.value = !isVisible.value;
};
</script>

<template>
    <div class="flex flex-col gap-1 relative text-textColor w-full">
        <label :for="id" class="font-bold text-sm" v-if="label">{{
            label
        }}</label>

        <div class="relative">
            <input
                :type="(type, !isVisible ? type : 'text')"
                class="outline-none border-2 border-accent bg-transparent py-2 px-3 rounded-md w-full text-sm disabled:bg-secondary disabled:text-accent disabled:cursor-not-allowed"
                v-model="model"
                ref="input"
                :id="id"
                :autofocus="autofocus"
                :required="required"
                :disabled="disabled"
            />

            <div
                @click="toggle"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer flex items-center justify-center"
                v-if="type === 'password'"
            >
                <EyeIcon class="h-5 w-5 bg-secondary" v-if="isVisible" />
                <EyeSlashIcon class="h-5 w-5 bg-secondary" v-else />
            </div>
        </div>

        <div class="text-sm text-red-400" v-if="err">{{ err }}</div>
    </div>
</template>
