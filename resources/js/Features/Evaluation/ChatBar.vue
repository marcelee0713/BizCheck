<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import { Evaluation } from "./types/evaluation-type";
import send from "../../../../public/images/send.svg";

const props = defineProps<{
    scrollContainer: HTMLElement | null;
    evaluation: Evaluation;
    isTyping: boolean;
    scrollToBottom: () => void;
}>();

const textareaRef = ref<HTMLTextAreaElement | null>(null);

const form = useForm({
    message: "",
});

const handleKeyDown = (event: KeyboardEvent) => {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        onSubmit();
    }
};

const onSubmit = async () => {
    if (form.message.trim() === "" || props.isTyping) return;

    form.post(`/chat/${props.evaluation.id}`, {
        async onStart() {
            await nextTick();
            props.scrollToBottom();
            form.reset();
        },
        async onSuccess() {
            await nextTick();
            props.scrollToBottom();
        },
    });
};

const adjustHeight = () => {
    if (textareaRef.value) {
        textareaRef.value.style.height = "auto";
        textareaRef.value.style.height = `${textareaRef.value.scrollHeight}px`;
    }
};
</script>
<template>
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
</template>
