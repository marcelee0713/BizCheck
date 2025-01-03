<script setup lang="ts">
defineProps<{
    preview: string;
    onChange: (payload: Event) => void;
    onRemove: () => void;
    err?: string;
}>();
</script>

<template>
    <div class="flex gap-5 items-center">
        <img
            :src="preview"
            class="w-[150px] h-[150px] flex-shrink-0 bg-accent rounded-full drop-shadow-lg object-cover"
        />

        <div class="flex flex-col gap-2 w-1/2">
            <div class="font-bold">Profile Picture</div>

            <div class="flex gap-2 w-full">
                <label
                    for="avatar"
                    class="text-background flex-1 bg-primary font-bold rounded-md text-center cursor-pointer py-2"
                >
                    Change
                </label>

                <button
                    v-on:click="onRemove"
                    class="text-background flex-1 bg-accent font-bold rounded-md text-center py-2 hover:bg-red-400"
                >
                    Remove
                </button>
            </div>

            <div class="text-sm text-red-400" v-if="err">
                {{ err }}
            </div>
        </div>

        <input type="file" id="avatar" @input="onChange" class="hidden" />
    </div>
</template>
