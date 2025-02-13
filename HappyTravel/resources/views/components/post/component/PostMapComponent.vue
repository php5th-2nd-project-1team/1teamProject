<template>
  <div v-if="isLoading">    
  </div>
  <KakaoMap 
    v-else 
    v-once
    :key="mapKey"
    :lat="initialLat" 
    :lng="initialLon" 
    :draggable="true" 
    :scrollwheel="true" 
    @onLoadKakaoMap="onLoadKakaoMap"
  >
    <KakaoMapMarker 
      :lat="initialLat" 
      :lng="initialLon" 
    />
  </KakaoMap>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { KakaoMap, KakaoMapMarker } from 'vue3-kakao-maps';
import { useStore } from 'vuex';

const map = ref();
const store = useStore();
const mapKey = ref(0);

// 초기 좌표값을 저장
const initialLat = ref(null);
const initialLon = ref(null);

const PostDetail = computed(() => store.state.post.postDetail);
const isLoading = computed(() => store.state.post.isLoading);

onMounted(() => {
  // 컴포넌트 마운트 시 한 번만 좌표값 설정
  initialLat.value = PostDetail.value.post_lat;
  initialLon.value = PostDetail.value.post_lon;
});

const onLoadKakaoMap = (mapRef) => {
  if (!map.value) {
    map.value = mapRef;
  }
};
</script>