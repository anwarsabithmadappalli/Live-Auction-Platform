<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    title: '',
    description: '',
    starting_price: '',
    starts_at: '',
    ends_at: '',
});
</script>

<template>
    <Head title="Create Auction" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create Auction
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="form.post(route('auctions.store'))" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="title">Title</label>
                            <input v-model="form.title" type="text" id="title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <span v-if="form.errors.title" class="text-sm text-red-500">{{ form.errors.title }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="description">Description</label>
                            <textarea v-model="form.description" id="description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" rows="3"></textarea>
                            <span v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="starting_price">Starting Price</label>
                            <input v-model="form.starting_price" type="number" step="0.01" id="starting_price" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <span v-if="form.errors.starting_price" class="text-sm text-red-500">{{ form.errors.starting_price }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="starts_at">Start Time</label>
                            <input v-model="form.starts_at" type="datetime-local" id="starts_at" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <span v-if="form.errors.starts_at" class="text-sm text-red-500">{{ form.errors.starts_at }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="ends_at">End Time</label>
                            <input v-model="form.ends_at" type="datetime-local" id="ends_at" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <span v-if="form.errors.ends_at" class="text-sm text-red-500">{{ form.errors.ends_at }}</span>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                                Create Auction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
