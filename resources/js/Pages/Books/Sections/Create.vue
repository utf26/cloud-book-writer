<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    sections: {
        type: Array,
        required: true
    }
})

const form = useForm({
    title: '',
    content: '',
    parent_id: null
});

const createSection = () => {
    form.post(route('sections.store', props.book.id));
};
</script>

<template>
    <Head title="Create New Section" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create New Section</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-4 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="createSection">
                            <div>
                                <InputLabel for="title" value="Section Title" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="content" value="Section Content" />

                                <TextArea
                                    id="content"
                                    class="mt-1 block w-full"
                                    v-model="form.content"
                                />

                                <InputError class="mt-2" :message="form.errors.content" />
                            </div>

                            <div>
                                <InputLabel for="parent_id" value="Parent Section (Optional)" />

                                <SelectInput
                                    id="parent_id"
                                    v-model="form.parent_id"
                                    :options="sections"
                                    class="mt-1 block w-full"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.parent_id" />
                            </div>

                            <div class="flex justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Section
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
