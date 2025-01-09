<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from "vue";
import { ChevronDownIcon } from "@heroicons/vue/24/solid";

const props = defineProps<{
    label: string;
    arr: string[];
    onSelect: (i: number) => void;
    err?: string;
    initialIndex?: number;
}>();

const element = ref<string>(
    props.initialIndex ? props.arr[props.initialIndex] : ""
);

const popUp = ref<boolean>(false);

const popUpRef = ref<HTMLElement | null>(null);
const wrapperRef = ref<HTMLElement | null>(null);

const handleClickOutside = (event: MouseEvent) => {
    if (
        popUpRef.value &&
        !popUpRef.value.contains(event.target as Node) &&
        wrapperRef.value &&
        !wrapperRef.value.contains(event.target as Node)
    ) {
        popUp.value = false;
    }
};

const onClickPopUp = () => {
    popUp.value = !popUp.value;
};

const onClickElement = (i: number) => {
    props.onSelect(i);
    element.value = props.arr[i];
    popUp.value = false;
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <div class="flex-1 flex flex-col gap-1 relative text-textColor">
        <div class="font-bold text-sm">{{ label }}</div>

        <div
            ref="wrapperRef"
            v-on:click="onClickPopUp"
            class="outline-none border-2 border-accent bg-transparent py-2 px-3 rounded-md w-full text-sm cursor-pointer h-full"
        >
            <div class="flex items-center justify-between gap-2">
                <div>
                    {{ element }}
                </div>

                <ChevronDownIcon class="h-5 w-5" />
            </div>
        </div>

        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <ul
                v-show="popUp"
                ref="popUpRef"
                class="absolute border border-accent w-full min-h-[150px] max-h-[300px] bg-background shadow-lg z-10 rounded-lg top-[70px] overflow-y-auto"
            >
                <li
                    v-for="(val, i) in arr"
                    v-on:click="onClickElement(i)"
                    v-text="val"
                    class="px-3 py-2 hover:bg-accent cursor-pointer"
                />
            </ul>
        </Transition>

        <div class="text-sm text-red-400">{{ err }}</div>
    </div>
</template>
