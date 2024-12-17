<template>
  <KakaoMap :lat="37.34083789" :lng="126.882195" :draggable="false" @onLoadKakaoMap="onLoadKakaoMap">
    <KakaoMapMarker :lat="37.34083789" :lng="126.882195" />
  </KakaoMap>
</template>

<script setup>
  import { ref } from 'vue';
  import { KakaoMap, KakaoMapMarker } from 'vue3-kakao-maps';

  const map = ref();

  const onLoadKakaoMap = (mapRef) => {
    map.value = mapRef;
  };

</script>