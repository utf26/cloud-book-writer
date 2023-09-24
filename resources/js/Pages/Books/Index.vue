<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    books: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Head title="My Books" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Books</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">List of Books</h3>
                            <Link :href="route('books.create')" class="px-4 py-1 font-semibold text-blue-500 border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Create New Book</Link>
                        </div>
                        <ul>
                            <li v-for="book in books" :key="book.id" class="py-2">
                                <Link :href="route('books.show', book.id)" class="text-blue-500 hover:underline">{{ book.title }}</Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
