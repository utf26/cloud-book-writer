<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
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
    },
    collaborator: Object,
    collaboratorRole: Number
})

const form = useForm({
    role_id: props.collaboratorRole
});

const editCollaborator = () => {
    form.put(route('collaborators.update', [props.book.id, props.collaborator.id]));
};
</script>

<template>
    <Head title="Edit Collaborator" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Collaborator</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="editCollaborator">
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
                                    Edit Collaborator
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
