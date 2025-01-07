<script setup lang="ts">
import { ref, onMounted, watch, nextTick, computed } from "vue";
import { EvaluationProps } from "@/Features/Evaluation/types/evaluation-type";
import userPfp from "../../../../public/images/profile.png";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import ChatContainer from "@/Features/Evaluation/ChatContainer.vue";
import ChatBar from "@/Features/Evaluation/ChatBar.vue";

const props = defineProps<EvaluationProps>();

const scrollContainer = ref<HTMLElement | null>(null);
const typingMessage = ref("");
const isTyping = ref(false);

const typeMessage = (message: string): void => {
    isTyping.value = true;
    typingMessage.value = "";
    let index = 0;

    const typeNextChar = () => {
        if (index < message.length) {
            typingMessage.value += message[index];
            index++;
            setTimeout(typeNextChar, 10);
        } else {
            isTyping.value = false;
        }
    };

    typeNextChar();
};

const displayedResponses = computed(() => {
    const responses = props.responses.slice(1);
    const lastResponse = responses[responses.length - 1];

    if (isTyping.value && lastResponse?.sender === "assistant") {
        return [
            ...responses.slice(0, -1),
            {
                ...lastResponse,
                message: typingMessage.value,
            },
        ];
    }

    return responses;
});

const scrollToBottom = (): void => {
    if (scrollContainer.value) {
        const container = scrollContainer.value;
        const lastMessage = container.lastElementChild as HTMLElement;
        lastMessage?.scrollIntoView({
            behavior: "smooth",
            block: "end",
            inline: "nearest",
        });
    }
};

watch(
    () => props.responses,
    (newResponses: any[]) => {
        setTimeout(async () => {
            await nextTick();
            scrollToBottom();

            const lastResponse = newResponses[newResponses.length - 1];
            if (lastResponse.sender === "assistant") {
                typeMessage(lastResponse.message);
            }
        }, 0);
    },
    { deep: true }
);
</script>

<template>
    <Head :title="'Evaluation -' + props.evaluation.id.split('-')[0]" />
    <AuthenticatedLayout>
        <main class="relative flex flex-col items-center overflow-hidden">
            <ChatContainer
                ref="scrollContainer"
                :displayed-responses="displayedResponses"
                :user-pfp="$page.props.auth.user.avatar ?? userPfp"
            />
            <ChatBar
                :scroll-container="scrollContainer"
                :evaluation="props.evaluation"
                :is-typing="isTyping"
                :scroll-to-bottom="scrollToBottom"
            />
        </main>
    </AuthenticatedLayout>
</template>
