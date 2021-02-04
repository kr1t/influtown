<template>
  <div class="container mb-4">
    <div class="card p-4 mt-4">
      <div class="clearfix"></div>
      <div class="text-center">
        <img :src="influ.profile_url" class="w-75" />
        <h2>{{ influ.name }} ({{ influ.nickname }})</h2>
      </div>
      <hr />
      <p>
        เพศ : {{ influ.gender_text }}
        <br />
        อายุ : {{ influ.age_text }}
        <br />
        ความถนัด :
        <span v-for="type in influ.type_text" :key="type" class="mr-2">{{
          type
        }}</span>
        <br />
        สิ่งที่ไม่ถนัด : {{ influ.dislike }}
        <br />
        บัดเจ้ด : {{ influ.budget }}
        <br />
        ผู้ติดตาม : {{ influ.follow_text }}
      </p>
      <hr />
      เบอร์โทร :
      <a :href="`tel:${influ.user.tel}`">
        {{ influ.user.tel }}
      </a>
      <br />
      อีเมล :
      <a :href="`mailto:${influ.user.email}`">
        {{ influ.user.email }}
      </a>

      <hr />
      ภาพผลงานการรีวิว
      <div v-for="img in influ.images" :key="img.id">
        <img :src="img.image_url" class="w-100 mt-3" />
      </div>

      <div class="mt-4">
        <router-link :to="`/report?id=${id}`">
          <button class="btn btn-outline-secondary w-100">
            <img
              src="https://cdn1.iconfinder.com/data/icons/hawcons/32/698987-icon-14-flag-512.png"
              width="30"
              alt=""
            />
            รายงานหรือแจ้งปัญหา
          </button>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
require("vue-image-lightbox/dist/vue-image-lightbox.min.css");
import LightBox from "vue-image-lightbox";

export default {
  components: {
    LightBoxx: LightBox
  },
  data: () => ({
    influ: {},
    media: [
      {
        // For image
        thumb: "http://example.com/thumb.jpg",
        src: "http://example.com/image.jpg",
        caption: "caption to display. receive <html> <b>tag</b>", // Optional
        srcset: "..." // Optional for displaying responsive images
      },
      {
        // For video
        thumb:
          "https://s3-us-west-1.amazonaws.com/powr/defaults/image-slider2.jpg",
        sources: [
          {
            src: "https://www.w3schools.com/html/mov_bbb.mp4",
            type: "video/mp4"
          }
        ],
        type: "video",
        caption: "<h4>Monsters Inc.</h4>",
        width: 800, // required
        height: 600, // required
        autoplay: true //Optional to autoplay video when lightbox opens
      }
    ]
  }),
  methods: {
    async fetch() {
      const { data } = await axios.get(`/api/influencers/${this.id}`);
      this.influ = data;
    }
  },
  computed: {
    id() {
      let lp = this.$liffParams.get("id");
      let t = lp ? lp : this.$route.query.id;
      return t;
    }
  },
  created() {
    this.fetch();
  }
};
</script>

<style></style>
