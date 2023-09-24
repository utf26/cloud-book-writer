<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    collaborators: {
        type: Array,
        required: true
    }
})

const editCollaborator = (userId) => {
    if (confirm('Are you sure you want to remove this collaborator?')) {
        router.delete(route('collaborators.destroy', [props.book.id, userId]));
    }
};

const removeCollaborator = (userId) => {
    if (confirm('Are you sure you want to remove this collaborator?')) {
        router.delete(route('collaborators.destroy', [props.book.id, userId]));
    }
};
</script>

<template>
    <Head title="Collaborators" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Collaborators</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <Link :href="route('collaborators.create', book.id)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Add Collaborator
                    </Link>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Collaborators List -->
                        <ul class="space-y-4">
                            <li v-for="collaborator in collaborators" :key="collaborator.id"
                                class="flex justify-between items-center border-b pb-2">
                            <span class="text-lg">
                                {{ collaborator.name }}
                                <span class="text-sm text-gray-600 ml-2">({{ collaborator.roles[0].name }})</span>
                            </span>
                                <div class="space-x-4">
                                    <Link :href="route('collaborators.edit', [book.id, collaborator.id])"
                                          class="text-indigo-500 hover:text-indigo-700 transition duration-150">Edit
                                    </Link>
                                    <button @click="removeCollaborator(collaborator.id)"
                                            class="text-red-500 hover:text-red-700 transition duration-150">Remove
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
