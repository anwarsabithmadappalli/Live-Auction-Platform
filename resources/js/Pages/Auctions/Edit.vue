<template>
    <Head title="Edit Auction" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Auction</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white"
                            />
                            <p v-if="form.errors.title" class="text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea
                                v-model="form.description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white"
                            ></textarea>
                            <p v-if="form.errors.description" class="text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Starting Price</label>
                            <input
                                v-model="form.starting_price"
                                type="number"
                                step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white"
                            />
                            <p v-if="form.errors.starting_price" class="text-sm text-red-600">{{ form.errors.starting_price }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                            <input
                                v-model="form.starts_at"
                                type="datetime-local"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white"
                            />
                            <p v-if="form.errors.starts_at" class="text-sm text-red-600">{{ form.errors.starts_at }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                            <input
                                v-model="form.ends_at"
                                type="datetime-local"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white"
                            />
                            <p v-if="form.errors.ends_at" class="text-sm text-red-600">{{ form.errors.ends_at }}</p>
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                :disabled="form.processing"
                            >
                                Update Auction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    auction: Object
})

const form = useForm({
    title: props.auction.title || '',
    description: props.auction.description || '',
    starting_price: props.auction.starting_price || '',
    starts_at: props.auction.starts_at?.slice(0, 16) || '',
    ends_at: props.auction.ends_at?.slice(0, 16) || '',
})

const submit = () => {
    form.patch(route('auctions.update', props.auction.id))
}
</script>
