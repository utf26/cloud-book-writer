<script setup>
import {ref, defineProps, defineEmits, watch} from 'vue';

const { modelValue, options } = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
    options: {
        type: Array,
        required: true,
    }
});

const emits = defineEmits(['update:modelValue']);

const selectedValue = ref(modelValue);

watch(selectedValue, (newValue) => {
    emits('update:modelValue', newValue);
});
</script>

<template>
    <div class="relative">
        <select
            v-model="selectedValue"
            class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
            <option :value="null">Select an option</option>
            <option v-for="(option, key) in options" :key="key" :value="key">{{ option }}</option>
        </select>
    </div>
</template>
