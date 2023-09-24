<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const form = useForm({
    title: '',
});

const submit = () => {
    form.post(route('books.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Create New Book" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create New Book</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="flex flex-col mb-6">
                                <InputLabel for="title" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Title:</InputLabel>
                                <div class="relative">
                                    <TextInput v-model="form.title" type="text" id="title" name="title" class="text-sm sm:text-base relative w-full border rounded placeholder-gray-400 text-gray-900 py-2 px-3 focus:border-blue-400 focus:outline-none"></TextInput>
                                </div>
                            </div>
                            <div class="flex w-full">
                                <PrimaryButton type="submit" class="w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-full tracking-wide font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition duration-300 ease-in-out">
                                    Create
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
