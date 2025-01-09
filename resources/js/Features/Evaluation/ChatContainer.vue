<script setup lang="ts">
import {
    ref,
    defineExpose,
    onMounted,
    watch,
    nextTick,
    onBeforeUnmount,
} from "vue";
import { Message } from "./types/evaluation-type";
import { marked } from "marked";
import aiPfp from "../../../../public/images/ai.png";

const container = ref<HTMLElement | null>(null);

const props = defineProps<{
    displayedResponses: Message[];
    userPfp: string;
}>();

const previousScrollY = ref(0);
const isScrolledUp = ref(false);

const scrollToBottom = (): void => {
    if (container.value) {
        const children = container.value.children;
        if (children.length > 0) {
            const lastChild = children[children.length - 1] as HTMLElement;
            lastChild.scrollIntoView({
                behavior: "smooth",
                block: "end",
                inline: "nearest",
            });
        }
    }
};

const handleScroll = () => {
    if (container.value) {
        const currentScrollY = container.value.scrollTop;

        if (currentScrollY < previousScrollY.value) {
            if (!isScrolledUp.value) isScrolledUp.value = true;
        } else {
            isScrolledUp.value = false;
        }

        previousScrollY.value = currentScrollY;
    }
};

onMounted(async () => {
    await nextTick();
    scrollToBottom();

    if (container.value) {
        container.value.addEventListener("scroll", handleScroll);
    }
});

onBeforeUnmount(() => {
    if (container.value) {
        container.value.removeEventListener("scroll", handleScroll);
    }
});

watch(
    () => props.displayedResponses,
    async () => {
        if (!isScrolledUp.value) {
            await nextTick();
            scrollToBottom();
        }
    },
    { deep: true }
);
</script>

<template>
    <div
        class="flex-1 flex flex-col p-5 gap-5 w-full items-center overflow-y-auto max-h-screen"
        ref="container"
    >
        <div
            v-for="(response, i) in displayedResponses"
            :key="i + 1"
            class="flex relative gap-5 max-w-[600px] w-full"
        >
            <div
                v-html="marked.parse(response.message)"
                class="w-fit prose rounded-lg font-montserrat p-4 prose-headings:text-textColor prose-p:text-textColor prose-strong:text-textColor !text-textColor text-sm text-wrap break-words"
                :class="{
                    'bg-secondary shadow-lg w-[450px] ml-auto':
                        response.sender === 'user',
                }"
            />
            <img
                :src="response.sender === 'assistant' ? aiPfp : userPfp"
                class="w-[50px] h-[50px] rounded-full object-cover absolute bottom-5 -left-[60px] bg-secondary"
                :class="{
                    hidden: response.sender === 'user',
                }"
            />
        </div>
    </div>
</template>
