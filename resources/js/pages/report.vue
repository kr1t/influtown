<template>
  <div class="container pb-4">
    <div v-if="status">
      <div v-if="currentPage == 1">
        <div class="row">
          <b-container fluid>
            <br />
            <h3 class="text-center">แจ้งปัญหา</h3>
            <b-row class="my-1">
              <b-col sm="12">
                <label for="input-default">1: ชื่อผู้แจ้ง</label>
                <input
                  type="text"
                  :value="report.user.first_name + ' ' + report.user.last_name"
                  class="form-control"
                  disabled
                />
              </b-col>
            </b-row>

            <br />
            <b-row class="my-1">
              <b-col sm="12">
                <label for="input-default">2: เบอร์ติดต่อของท่าน</label>
                <input type="text" class="form-control" v-model="form.tel" />
              </b-col>
            </b-row>

            <b-row class="mt-2">
              <b-col sm="12">
                <label for="textarea-default">3:ปัญหาที่เกิดขึ้น</label>
                <b-form-textarea
                  id="textarea-default"
                  placeholder=""
                  v-model="form.problem"
                ></b-form-textarea>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="12">
                <label for="input-default"
                  >4: ชื่ออินฟลูเชอร์ที่ท่านต้องการรายงาน</label
                >
                <input
                  type="text"
                  :value="report.influencer.name"
                  class="form-control"
                  disabled
                />
              </b-col>
            </b-row>

            <div class="card p-4 mt-5">
              <div class="card-title">
                หลักฐานรูปภาพ
                <input
                  type="file"
                  multiple
                  class="form-control"
                  @change="setReview"
                />
              </div>
            </div>
            <br />

            <router-link :to="`/influ?id=${id}`">
              <b-button variant="secondary">ย้อนกลับ</b-button>
            </router-link>
            <b-button variant="success" @click="reportData()"
              >ส่งหลักฐาน</b-button
            >
          </b-container>
        </div>
      </div>
      <div v-if="currentPage == 2">
        <div class="card p-5 mt-3">
          ทำการแจ้งข้อมูลรายงานของท่านเสร็จแล้วกรุณารอแอดมินติดต่อกลับ
        </div>
      </div>
    </div>

    <div v-else>
      <div class="card p-5 mt-3">
        Influencer Not Found
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    report: {},
    status: true,
    currentPage: 1,
    form: {
      tel: null,
      user_id: null,
      problem: null,
      influencer_id: null,
      image_urls: []
    }
  }),
  methods: {
    async reportData() {
      if (!this.form.problem) {
        alert("กรุณากรอกปัญหา");
        return false;
      }
      if (!this.form.tel) {
        alert("กรุณากรอกเบอร์");
        return false;
      }

      if (!this.form.image_urls.length) {
        alert("กรุณาอัพโหลดภาพ");
        return false;
      }
      const { data } = await axios.post(`/api/report`, this.form);
      if (data.status == true) {
        this.currentPage = 2;
      }
      return data;
    },
    async fetch() {
      const { data } = await axios.get(`/api/report/${this.id}`, {
        params: {
          line_user_id: this.user.id
        }
      });

      if (data.status == "failed") {
        this.status = false;
      }
      this.form.tel = data.user.tel;
      this.form.user_id = data.user.id;
      this.form.influencer_id = data.influencer.id;

      this.report = data;
    },
    async uploadImg(file) {
      let form = new FormData();
      form.append("uploadFileObj", file);
      const { data } = await axios.post("/api/image/upload", form);
      console.log(data);
      return data.url;
    },
    async setReview(event) {
      let files = event.target.files;
      for (
        let i = 0;
        i < files.length;
        i++ //for multiple files
      ) {
        let f = files[i];
        let name = files[i].name;
        let u = await this.uploadImg(f);
        this.form.image_urls.push(u);
      }
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
