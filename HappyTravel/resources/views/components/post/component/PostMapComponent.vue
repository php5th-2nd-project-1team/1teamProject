<template>
  <div v-if="isLoading">    
  </div>
  <KakaoMap 
    v-else 
    :key="mapKey"
    :lat="PostDetail.post_lat" 
    :lng="PostDetail.post_lon" 
    :draggable="true" 
    :scrollwheel="true" 
    @onLoadKakaoMap="onLoadKakaoMap"
  >
    <KakaoMapMarker 
      :lat="PostDetail.post_lat" 
      :lng="PostDetail.post_lon" 
    />
  </KakaoMap>
  <button @click="test">test</button>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { KakaoMap, KakaoMapMarker } from 'vue3-kakao-maps';
import { useStore } from 'vuex';

const map = ref();
const store = useStore();
const mapKey = ref(0);

const PostDetail = computed(() => store.state.post.postDetail);
const isLoading = computed(() => store.state.post.isLoading);

const onLoadKakaoMap = (mapRef) => {
  if (!map.value) {
    map.value = mapRef;
  }
};

const test = () => {
  console.log(PostDetail.value);
};
</script>