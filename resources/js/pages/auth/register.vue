<template>
  <div>
    <div v-if="page == 0" class="p-5">Loading...</div>
    <div class="container" v-if="page == 1">
      <div class="row">
        <div class="col-lg-8 m-auto pt-4">
          <card title="ลงทะเบียนสมาชิก">
            <form @submit.prevent="register" @keydown="form.onKeydown($event)">
              <!-- Name -->

              <div class="d-flex justify-content-center pt-4">
                <!-- <iomg src="assets/images/register-pic.png" alt="" width="40%" /> -->
                <div class="imageProfile" v-if="user">
                  <img :src="user.image_url" width="130" />
                </div>
              </div>

              <div class="form-group row">
                <div class="col-6">
                  <input
                    v-model="form.first_name"
                    :class="{ 'is-invalid': form.errors.has('first_name') }"
                    class="form-control"
                    type="text"
                    name="name"
                    placeholder="ชื่อ"
                  />
                  <has-error :form="form" field="first_name" />
                </div>
                <div class="col-6">
                  <input
                    v-model="form.last_name"
                    :class="{ 'is-invalid': form.errors.has('last_name') }"
                    class="form-control"
                    type="text"
                    name="last_name"
                    placeholder="นามสกุล"
                  />
                  <has-error :form="form" field="last_name" />
                </div>
              </div>

              <div class="form-group row">
                <div class="col-6">
                  <input
                    v-model="form.tel"
                    :class="{ 'is-invalid': form.errors.has('tel') }"
                    class="form-control"
                    type="tel"
                    name="name"
                    placeholder="เบอร์โทรศัพท์"
                  />
                  <has-error :form="form" field="tel" />
                </div>
                <div class="col-6">
                  <input
                    v-model="form.email"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    class="form-control"
                    type="email"
                    name="last_name"
                    placeholder="อีเมล"
                  />
                  <has-error :form="form" field="email" />
                </div>
              </div>

              <div class="form-group">
                <input
                  v-model="form.zipcode"
                  :class="{ 'is-invalid': form.errors.has('zipcode') }"
                  class="form-control"
                  type="tel"
                  name="name"
                  placeholder="รหัสไปรษณีย์"
                />
                <has-error :form="form" field="zipcode" />
              </div>

              <div class="form-group">
                <input
                  v-model="form.address"
                  :class="{ 'is-invalid': form.errors.has('address') }"
                  class="form-control"
                  type="text"
                  name="name"
                  placeholder="ที่อยู่"
                />
                <has-error :form="form" field="address" />
              </div>

              <div class="form-group">
                <input
                  v-model="form.city"
                  :class="{ 'is-invalid': form.errors.has('city') }"
                  class="form-control"
                  type="text"
                  name="name"
                  placeholder="อำเภอ"
                />
                <has-error :form="form" field="city" />
              </div>

              <div class="form-group">
                <input
                  v-model="form.province"
                  :class="{ 'is-invalid': form.errors.has('province') }"
                  class="form-control"
                  type="text"
                  name="name"
                  placeholder="จังหวัด"
                />
                <has-error :form="form" field="province" />
              </div>

              <div class="form-group row">
                <div class="col-md-7 offset-md-3 d-flex">
                  <!-- Submit Button -->
                  <v-button :loading="form.busy" class="w-100" type="success">
                    สมัครสมาชิก
                  </v-button>

                  <!-- GitHub Register Button -->
                  <login-with-github />
                </div>
              </div>
            </form>
          </card>
        </div>
      </div>
    </div>
    <div v-if="page == 2" class="w-100">
      <img
        src="https://i.imgur.com/nrnTHFi.jpg"
        class="w-100"
        @click="page = 3"
      />
    </div>

    <div v-if="page == 3">
      <influencerRegister @next="f()" />
    </div>

    <div v-if="page == 4">
      <h1 class="text-primary mt-4 text-center">คุณลงทะเบียนสำเร็จแล้ว</h1>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import LoginWithGithub from "~/components/LoginWithGithub";
import influencerRegister from "./influenRegister";

import axios from "axios";
export default {
  middleware: "guest",

  components: {
    LoginWithGithub,
    influencerRegister,
  },

  metaInfo() {
    return { title: "ลงทะเบียน" };
  },

  data: () => ({
    page: 3,
    form: new Form({
      first_name: "",
      last_name: "",
      zipcode: "",
      address: "",
      city: "",
      province: "",
      line_user_id: "",
      email: "",
      password: "",
      password_confirmation: "",
    }),
    mustVerifyEmail: false,
  }),

  methods: {
    async register() {
      this.form.line_user_id = this.user.id;
      const { data, status } = await this.form.post("/api/register");

      if (status == 200) {
        this.page = 2;
        this.toTop();
      }
    },
    f() {
      this.page = 4;
      this.toTop();
    },
  },
  watch: {
    async user() {
      const { data } = await axios.get(
        `/api/line/user/check/register?line_user_id=${this.user.id}`
      );

      if (data.result.isRegistered) {
        this.page = 2;
        this.loadingStop();
      } else {
        this.page = 1;
      }

      if (data.result.isRegisteredF) {
        this.page = 4;
        this.loadingStop();
      }

      this.form.email = this.user.email;
    },
  },
  async created() {
    await this.initializeLiff("register", true, "ลงทะเบียน");
  },
};
</script>

<style lang="scss" scoped>
.imageProfile img {
  border-radius: 50%;
  border: 1px solid #ccc;
  padding: 5px;
  margin-bottom: 25px;
}
</style>
