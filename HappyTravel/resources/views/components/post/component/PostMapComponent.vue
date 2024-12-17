<template>
  <KakaoMap :lat="props.lat" :lng="props.lon" :draggable="false" @onLoadKakaoMap="onLoadKakaoMap">
    <KakaoMapMarker :lat="props.lat" :lng="props.lon" />
  </KakaoMap>
</template>

<script setup>
  import { ref, defineProps } from 'vue';
  import { KakaoMap, KakaoMapMarker } from 'vue3-kakao-maps';

  const map = ref();

  const props = defineProps({
    lat : Number
    ,lon : Number
  })

  const onLoadKakaoMap = (mapRef) => {
    map.value = mapRef;
  };

</script>