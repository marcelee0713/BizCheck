<script setup lang="ts">
import { ref, onMounted, watch, nextTick, computed } from "vue";
import {
    Evaluation,
    Message,
} from "@/Features/Evaluation/types/evaluation-type";
import { marked } from "marked";
import aiPfp from "../../../../public/images/ai.png";
import userPfp from "../../../../public/images/profile.png";
import send from "../../../../public/images/send.svg";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { defineProps } from 'vue';

// Ensure type safety for props
interface EvaluationProps {
    evaluation: Evaluation;
    responses: Message[];
}

const props = defineProps<EvaluationProps>();

const form = useForm({
    message: "",
});

const scrollContainer = ref<HTMLElement | null>(null);
const textareaRef = ref<HTMLTextAreaElement | null>(null);
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
            setTimeout(typeNextChar, Math.random() * 50 + 20);
        } else {
            isTyping.value = false;
        }
    };

    typeNextChar();
};


const displayedResponses = computed(() => {
    const responses = props.responses.slice(1);
    const lastResponse = responses[responses.length - 1];
    
    if (isTyping.value && lastResponse?.sender === 'assistant') {
        return [
            ...responses.slice(0, -1),
            { 
                ...lastResponse, 
                message: typingMessage.value 
            }
        ];
    }
    
    return responses;
});

const adjustHeight = () => {
    if (textareaRef.value) {
        textareaRef.value.style.height = "auto";
        textareaRef.value.style.height = `${textareaRef.value.scrollHeight}px`;
    }
};

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

onMounted(() => {
    setTimeout(async () => {
        await nextTick();
        scrollToBottom();
    }, 0);
});

watch(() => props.responses, (newResponses: any[]) => {
    setTimeout(async () => {
        await nextTick();
        scrollToBottom();

        
        const lastResponse = newResponses[newResponses.length - 1];
        if (lastResponse.sender === 'assistant') {
            typeMessage(lastResponse.message);
        }
    }, 0);
}, { deep: true });
const handleKeyDown = (event: KeyboardEvent) => {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        onSubmit();
    }
};

const onSubmit = async () => {
    if (form.message.trim() === "" || isTyping.value) return;

    form.post(`/chat/${props.evaluation.id}`, {
        async onStart() {
            await nextTick();
            scrollToBottom();
            form.reset();
        },
        async onSuccess() {
            await nextTick();
            scrollToBottom();
        },
    });
};
</script>

<template>
    <Head :title="'Evaluation -' + props.evaluation.id.split('-')[0]" />
    <AuthenticatedLayout>
        <main class="relative flex flex-col items-center overflow-hidden">
            <div
                class="flex-1 flex flex-col p-5 gap-5 w-full items-center overflow-y-auto max-h-screen"
                ref="scrollContainer"
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

            <form
                @submit.prevent="onSubmit"
                class="h-auto w-full bg-secondary z-10 py-4 flex gap-5 justify-center items-center text-textColor"
            >
                <div
                    class="max-w-[600px] w-full h-fit relative flex justify-end items-end"
                >
                    <textarea
                        :disabled="form.processing || isTyping"
                        v-model="form.message"
                        @input="adjustHeight"
                        @keydown="handleKeyDown"
                        ref="textareaRef"
                        placeholder="Type your message..."
                        class="w-full bg-background border border-accent border-lg rounded-lg outline-none px-4 py-2 min-h-[50px] resize-none max-h-[125px]"
                    />

                    <button
                        :disabled="form.processing || isTyping"
                        type="submit"
                        class="absolute -right-[70px] bg-background rounded-full h-[50px] w-[50px] flex items-center justify-center cursor-pointer border border-accent hover:bg-primary transition-colors duration-300"
                    >
                        <img :src="send" alt="Send" class="h-[30px] w-[30px]" />
                    </button>
                </div>
            </form>
        </main>
    </AuthenticatedLayout>
</template>
