<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
})

const form = useForm({
    email: '',
    role_id: '2'
});

const addCollaborator = () => {
    form.post(route('collaborators.store', props.book.id));
};
</script>

<template>
    <Head title="Add Collaborator" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add Collaborator</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="addCollaborator">
                            <div>
                                <InputLabel for="email" value="Collaborator Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    v-model="form.email"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-1">
                                <InputLabel for="role" value="Role" />

                                <SelectInput
                                    id="role"
                                    v-model="form.role_id"
                                    :options="roles"
                                    class="mt-1 block w-full"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.role_id" />
                            </div>

                            <div class="flex justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Add Collaborator
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
