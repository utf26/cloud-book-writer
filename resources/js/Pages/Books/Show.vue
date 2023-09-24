<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import SectionDisplay from "@/Components/SectionDisplay.vue";
import {computed} from "vue";

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    userRole: {
        type: Object,
        required: false
    }
})

const page = usePage()

const isAuthor = computed(() => {
    if (props.userRole?.name === 'Author') return true;
    else return props.book.author_id === page.props.auth.user.id;
})
</script>

<template>
    <Head :title="book.title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ book.title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <!-- Options for sections -->
                    <div class="mb-4" v-if="isAuthor">
                        <Link :href="route('sections.create', book.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Section
                        </Link>
                    </div>

                    <!-- Options for collaborators -->
                    <div class="flex justify-end mb-4" v-if="isAuthor">
                        <Link :href="route('collaborators.index', book.id)" v-if="book.collaborators.length > 0" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            View Collaborators
                        </Link>
                        <Link :href="route('collaborators.create', book.id)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Add Collaborator
                        </Link>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Recursive display of sections -->
                        <SectionDisplay v-for="section in book.sections" :key="section.id" :book="book" :section="section" :depth="0"></SectionDisplay>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
