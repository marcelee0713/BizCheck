<script setup lang="ts">
import TextInput from "@/Components/TextInput.vue";
import { PlusIcon, XMarkIcon } from "@heroicons/vue/24/solid";

const model = defineModel<string[]>({
    required: true,
});

defineProps<{
    head: string;
    text: string;
}>();

const onChange = (event: Event, i: number) => {
    model.value[i] = (event.target as HTMLInputElement).value;
};

const onRemove = (i: number) => {
    model.value.splice(i, 1);
};

const onAdd = () => {
    const text = "";

    model.value.push(text);
};
</script>

<template>
    <div class="flex flex-col gap-[10px] text-textColor">
        <div class="flex flex-col">
            <div class="font-bold text-lg">{{ head }}</div>
            <div class="text-sm">
                {{ text }}
            </div>
        </div>

        <div
            v-for="(objective, i) in model"
            class="flex gap-5 items-center w-full pr-3"
        >
            <button
                v-on:click="onRemove(i)"
                class="h-full w-[20px] group flex items-center justify-center cursor-pointer"
            >
                <div
                    class="w-2 h-2 rounded-full bg-accent group-hover:hidden"
                ></div>
                <XMarkIcon
                    class="h-full w-full hidden group-hover:block text-primary"
                />
            </button>
            <TextInput
                type="text"
                autofocus
                :onChange="(event) => onChange(event, i)"
                v-model="model[i]"
            />
        </div>

        <div class="flex gap-5 items-center w-full pr-3">
            <div
                class="h-full w-[20px] group flex items-center justify-center cursor-pointer"
            >
                <div class="w-2 h-2 rounded-full bg-accent" />
            </div>
            <div
                v-on:click="onAdd"
                class="w-full flex gap-2 border border-accent rounded-md py-2 px-3 text-accent justify-center items-center hover:bg-accent hover:text-secondary transition-colors duration-300 cursor-pointer"
            >
                <PlusIcon class="h-5 w-5" />
                Add
            </div>
        </div>
    </div>
</template>
