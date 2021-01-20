<template>
  <div>
    <div class="container">
      <div class="pt-4 text-center">
        <h4>รายละเอียดการชำระเงิน</h4>
      </div>
      <div class="card">
        <div class="card-body">
          <table class="table">
            <tbody width="100%">
              <tr>
                <td>หมายเลขการจอง</td>
                <td>{{ billDetail.id }}</td>
              </tr>
              <tr>
                <td>ชื่อแพคเกจ</td>
                <td>Influencer Premium</td>
              </tr>
              <tr>
                <td>วัน/เวลาสมัคร</td>
                <td>{{ billDetail.today_t }}</td>
              </tr>
              <tr>
                <td>วัน/เวลาหมดอายุ</td>
                <td>{{ billDetail.expiry_t }}</td>
              </tr>
              <tr>
                <td>ราคา</td>
                <td>199 บาท</td>
              </tr>
            </tbody>
          </table>

          <Omise :amount="19900" :form="billDetail"></Omise>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Omise from "~/components/PaymentOmise";
import axios from "axios";
export default {
  components: {
    Omise,
  },
  data: () => ({
    billDetail: {},
  }),
  methods: {
    async fetch() {
      const { data } = await axios.get("/api/billDetail");
      this.billDetail = data;
    },
  },
  created() {
    this.fetch();
  },
};
</script>

<style>
.priceDetail tbody,
.priceDetail tr {
  width: 100%;
}
.priceDetail td {
  width: 50%;
}
</style>
