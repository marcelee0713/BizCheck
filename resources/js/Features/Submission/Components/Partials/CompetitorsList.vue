<script setup lang="ts">
import { Competitors } from "../../types/submission-type";

const props = defineProps<{
    head: string;
    text: string;
    type: "DIRECT" | "INDIRECT";
}>();

const model = defineModel<Competitors[]>({
    required: true,
});

const onChangeName = (event: Event, i: number) => {
    const name = (event.target as HTMLInputElement).value;
    model.value[i] = { ...model.value[i], name };
};

const onChangeDescription = (event: Event, i: number) => {
    const description = (event.target as HTMLInputElement).value;
    model.value[i] = { ...model.value[i], description };
};

const onRemove = (i: number) => {
    model.value.splice(i, 1);
};

const onAdd = () => {
    model.value.push({
        name: "",
        description: "",
        type: props.type,
    });
};
</script>

<template>
    <div class="flex flex-col gap-[10px] text-textColor">
        <div class="flex flex-col">
            <div class="font-bold text-lg">{{ head }}</div>
            <div class="text-sm">{{ text }}</div>
        </div>

        <div
            v-for="(competitor, i) in model"
            :key="i"
            class="flex gap-5 items-center w-full pr-3"
        >
            <button
                @click="onRemove(i)"
                class="h-full w-[20px] group flex items-center justify-center cursor-pointer"
            >
                <div
                    class="w-2 h-2 rounded-full bg-accent group-hover:hidden"
                ></div>
                <svg
                    class="h-full w-full hidden group-hover:block text-primary"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

            <div
                class="flex flex-col gap-1 outline-none border-2 border-accent bg-transparent py-2 px-3 rounded-md w-full text-sm"
            >
                <input
                    @input="(event) => onChangeName(event, i)"
                    type="text"
                    :value="competitor.name"
                    placeholder="Name of your Competitor"
                    class="font-bold outline-none bg-transparent placeholder:font-bold"
                />
                <input
                    @input="(event) => onChangeDescription(event, i)"
                    type="text"
                    :value="competitor.description"
                    placeholder="Explain how this business competes with yours."
                    class="outline-none bg-transparent text-sm"
                />
            </div>
        </div>

        <div class="flex gap-5 items-center w-full pr-3">
            <div
                class="h-full w-[20px] group flex items-center justify-center cursor-pointer"
            >
                <div class="w-2 h-2 rounded-full bg-accent"></div>
            </div>
            <div
                @click="onAdd"
                class="w-full flex gap-2 border border-accent rounded-md py-2 px-3 text-accent justify-center items-center hover:bg-accent hover:text-secondary transition-colors duration-300 cursor-pointer"
            >
                Add
            </div>
        </div>
    </div>
</template>
