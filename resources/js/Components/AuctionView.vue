<script setup>
import { onMounted, onUnmounted } from 'vue';

const auctionId = 1;

onMounted(() => {
  window.Echo.channel(`auction.${auctionId}`)
    .listen('BidPlaced', (e) => {
      console.log('New bid:', e.bid);
    });
});

onUnmounted(() => {
  window.Echo.leave(`auction.${auctionId}`);
});
</script>
