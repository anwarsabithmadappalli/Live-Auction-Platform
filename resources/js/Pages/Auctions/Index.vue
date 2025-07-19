<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

async function fetchAuctions() {
  try {
    const response = await axios.get('/auctions/list');
    auctions.value = response.data;
  } catch (error) {
    console.error('Failed to fetch auctions:', error);
  }
}

const props = defineProps({
    is_admin: Boolean
})

const auctions = ref([]);

const message = ref('');

onMounted(() => {
  fetchAuctions();
    window.Echo.channel('message-channel')
    .listen('.new-message', (e) => {
      message.value = e.message;
      fetchAuctions();
    });
});

const showModal = ref(false);
const bidAmount = ref('');
const selectedAuctionId = ref(null);
const currentAmount = ref('');

function createBid(id, amount) {
  selectedAuctionId.value = id;
  bidAmount.value = '';
  currentAmount.value = amount;
  console.log(currentAmount.value);
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  bidAmount.value = '';
}

async function submitBid() {
  try {
    if (!bidAmount.value || isNaN(bidAmount.value) || bidAmount.value <= 0) {
      alert('Please enter a valid bid amount.');
      return;
    } 

    if (bidAmount.value <= currentAmount.value){
      alert('Bid amount will be greater than current price: ' + currentAmount.value);
      return;
    }

    await axios.post('/bids/create', {
      auction_id: selectedAuctionId.value,
      amount: bidAmount.value,
    });

    closeModal();
  } catch (error) {
    console.error(error);
    alert('Failed to place bid.');
  }
}

function detailsAuction(id) {
  router.get(`/auctions/show/${id}`);
}

function editAuction(id) {
  router.get(`/auctions/edit/${id}`);
}

function deleteAuction(id) {
  if (confirm('Are you sure you want to delete this auction?')) {
    router.delete(`/auctions/delete/${id}`);
  }
}
</script>

<template>
  <Head title="Auctions" />

  <!-- Bid Modal -->
  <div
    v-if="showModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg w-80 shadow-lg">
      <h2 class="text-xl font-bold mb-4">Place Your Bid</h2>

      <input
        v-model="bidAmount"
        type="number"
        min="0"
        class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
        placeholder="Enter your bid amount"
      />

      <div class="flex justify-end space-x-2">
        <button
          @click="submitBid"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
          Submit
        </button>
        <button
          @click="closeModal"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>

  <!-- Page Layout -->
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Auctions
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-end" v-if="is_admin">
          <Link
            href="/auctions/create"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
          >
            Create Auction
          </Link>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table class="w-full table-auto border-collapse">
              <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                  <th class="border px-4 py-2 text-left">Title</th>
                  <th class="border px-4 py-2 text-left">Starting Price</th>
                  <th class="border px-4 py-2 text-left">Start Time</th>
                  <th class="border px-4 py-2 text-left">End Time</th>
                  <th class="border px-4 py-2 text-left">Total Bids</th>
                  <th class="border px-4 py-2 text-left">Current Price</th>
                  <th class="border px-4 py-2 text-left">Options</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="auction in auctions"
                  :key="auction.id"
                  class="hover:bg-gray-50 dark:hover:bg-gray-900"
                >
                  <td class="border px-4 py-2">{{ auction.title }}</td>
                  <td class="border px-4 py-2">₹{{ auction.starting_price }}</td>
                  <td class="border px-4 py-2">{{ new Date(auction.starts_at).toLocaleString() }}</td>
                  <td class="border px-4 py-2">{{ new Date(auction.ends_at).toLocaleString() }}</td>
                  <td class="border px-4 py-2">{{ auction.bids_count }}</td>
                  <td class="border px-4 py-2">₹{{ auction.current_price }}</td>
                  <td class="border px-4 py-2">
                    <button
                      @click="createBid(auction.id, auction.current_price)"
                      class="mx-1 px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                       v-if="!is_admin"
                    >
                      Bid
                    </button>
                    <button
                      @click="detailsAuction(auction.id)"
                      class="mx-1 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                       v-if="is_admin"
                    >
                      Details
                    </button>
                    <button
                      @click="editAuction(auction.id)"
                      class="mx-1 px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition"
                       v-if="is_admin"
                    >
                      Edit
                    </button>
                    <button
                      @click="deleteAuction(auction.id)"
                      class="mx-1 px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                       v-if="is_admin"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
                <tr v-if="auctions.length === 0">
                  <td
                    colspan="7"
                    class="text-center py-4 text-gray-500 dark:text-gray-400"
                  >
                    No auctions available.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
