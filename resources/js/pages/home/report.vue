<template>
  <div class="card p-4">
    Report
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">ปัญหาที่เกิดขึ้น</th>
          <th scope="col">ผู้โดนรายงาน</th>
          <th scope="col">รายงานโดย</th>
          <th scope="col">แจ้งเมื่อ</th>
          <th scope="col">action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="r in reports" :key="r.id">
          <th scope="row">{{ r.id }}</th>
          <td>{{ r.problem }}</td>

          <td>
            คุณ {{ r.influencer.name }} <br />

            <h4>
              <div class="badge badge-pill badge-primary" role="alert">
                Email: {{ r.influencer.user.email }}
              </div>
              <div class="badge badge-pill badge-success" role="alert">
                โทร: {{ r.influencer.user.tel }}
              </div>
            </h4>
          </td>
          <td>
            คุณ {{ r.user.first_name }} {{ r.user.last_name }} <br />
            <h4>
              <div class="badge badge-pill badge-primary" role="alert">
                Email: {{ r.user.email }}
              </div>
              <div class="badge badge-pill badge-success" role="alert">
                โทร: {{ r.tel }}
              </div>
            </h4>
          </td>
          <th scope="row">{{ r.created_at_text }}</th>
          <th scope="row">
            <button class="btn btn-primary" @click="closeCase(r.id)">
              ปิดเคส
            </button>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    reports: []
  }),
  methods: {
    async fetch() {
      const { data } = await axios.get("/api/reports");

      this.reports = data;
    },
    async closeCase(id) {
      var r = confirm("กรุณายืนยันการปิดเคส");
      if (r) {
        const { data } = await axios.post("/api/report/" + id + "/update");
        this.fetch();
      }
    }
  },
  created() {
    this.fetch();
  }
};
</script>

<style></style>
