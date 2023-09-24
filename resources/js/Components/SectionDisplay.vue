<script setup>
import {ref} from "vue";
import { ChevronDoubleRightIcon, ChevronDoubleDownIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    section: {
        type: Object,
        required: true
    },
    depth: {
        type: Number,
        required: true
    }
})

const form = useForm({
    title: props.section.title,
    content: props.section.content,
    parent_id: props.section.parent_id
});

const showContent = ref(true);
const editMode = ref(false);

const toggleContent = () => {
    showContent.value = !showContent.value;
};

const toggleEditMode = () => {
    editMode.value = !editMode.value;
};

const saveChanges = () => {
    form.put(route('sections.update', [props.book.id, props.section.id]));
    toggleEditMode();
};
</script>

<template>
    <div :style="{ marginLeft: `${depth * 16}px` }">
        <h3 class="text-lg font-semibold cursor-pointer hover:text-indigo-600 inline-flex" @click="toggleContent">
            <span class="pr-2 inline-block">
                <chevron-double-right-icon v-if="!showContent" class="h-5 w-5" />
                <chevron-double-down-icon v-else class="h-5 w-5" />
            </span>
            {{ section.title }}
            <button v-if="!editMode" @click.stop="toggleEditMode" class="ml-5 text-indigo-400 hover:underline">
                <pencil-square-icon class="h-5 w-5" />
            </button>
        </h3>

        <template v-if="editMode">
            <div class="flex">
                <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="flex flex-col space-y-4">
                        <TextInput v-model="form.title" placeholder="Section Title" class="bg-white dark:bg-gray-700 dark:text-gray-300"/>
                        <TextArea v-model="form.content" placeholder="Section Content" class="bg-white dark:bg-gray-700 dark:text-gray-300"></TextArea>
                        <div class="flex space-x-4">
                            <PrimaryButton @click="saveChanges" class="text-green-500 w-full">Save</PrimaryButton>
                            <SecondaryButton @click="toggleEditMode" class="text-red-500 w-full">Cancel</SecondaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <p v-if="showContent && section.content" class="text-gray-600 mb-3">{{ section.content }}</p>
        <SectionDisplay v-if="showContent" v-for="sub in section.subsections" :key="sub.id" :book="book" :section="sub" :depth="depth + 1"></SectionDisplay>
    </div>
</template>
