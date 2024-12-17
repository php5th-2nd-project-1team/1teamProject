<template>
  <div v-if="isLoading">    
  </div>
  <KakaoMap v-else :lat="PostDetail.post_lat" :lng="PostDetail.post_lon" :draggable="false" @onLoadKakaoMap="onLoadKakaoMap" >
    <KakaoMapMarker :lat="PostDetail.post_lat" :lng="PostDetail.post_lon" />
  </KakaoMap>

  <button @click="{PostDetail.post_lat = 37.34394261; PostDetail.post_lon = 126.694581; console.log(PostDetail)}">위도 경도 변경</button>
</template>

<script setup>
  import { computed, ref } from 'vue';
  import { KakaoMap, KakaoMapMarker } from 'vue3-kakao-maps';
  import { useStore } from 'vuex';

  const map = ref();

  const store = useStore();

  const PostDetail = computed(() => store.state.post.postDetail);
  const isLoading = computed(() => store.state.post.isLoading);

  const onLoadKakaoMap = (mapRef) => {
    map.value = mapRef;
  };

</script>