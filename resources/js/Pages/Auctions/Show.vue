<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    auction: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Auction Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Auction: {{ auction.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Auction Details</h3>

                    <p><strong>Title:</strong> {{ auction.title }}</p>
                    <p><strong>Description:</strong> {{ auction.description || 'N/A' }}</p>
                    <p><strong>Seller:</strong> {{ auction.user?.name }}</p>
                    <p><strong>Starting Price:</strong> ₹{{ auction.starting_price }}</p>
                    <p><strong>Current Price:</strong> ₹{{ auction.current_price }}</p>
                    <p><strong>Start Time:</strong> {{ new Date(auction.starts_at).toLocaleString() }}</p>
                    <p><strong>End Time:</strong> {{ new Date(auction.ends_at ).toLocaleString() }}</p>
                    <p><strong>Total Bids:</strong> {{ auction.bids?.length || 0 }}</p>

                    <div v-if="auction.bids?.length" class="mt-6">
                        <h4 class="font-semibold text-md mb-2">Bid History:</h4>
                        <ul class="list-disc pl-6 space-y-1">
                            <li v-for="bid in auction.bids" :key="bid.id">
                                ₹{{ bid.amount }} by User #{{ bid.user_id }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
