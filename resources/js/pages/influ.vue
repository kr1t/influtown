<template>
  <div class="container">
    <div class="card p-4 mt-4">
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
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    influ: {},
  }),
  methods: {
    async fetch() {
      const { data } = await axios.get(`/api/influencers/${this.id}`);
      this.influ = data;
    },
  },
  computed: {
    id() {
      let lp = this.$liffParams.get("id");
      let t = lp ? lp : this.$route.query.id;
      return t;
    },
  },
  created() {
    this.fetch();
  },
};
</script>

<style>
</style>
