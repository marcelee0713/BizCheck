<script setup lang="ts">
import { onMounted, ref } from "vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

const isVisible = ref<boolean>(false);

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineProps<{
    label: string;
    id: string;
    err?: string;
    type?: string;
    autofocus?: boolean;
    required?: boolean;
    disabled?: boolean;
}>();

defineExpose({ focus: () => input.value?.focus() });

const toggle = () => {
    isVisible.value = !isVisible.value;
};
</script>

<template>
    <div class="flex flex-col gap-1 relative text-textColor">
        <label :for="id" class="font-bold text-sm">{{ label }}</label>

        <div class="relative">
            <input
                :type="(type, !isVisible ? type : 'text')"
                class="outline-none border-2 border-accent bg-transparent py-2 px-3 rounded-md w-full text-sm"
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
