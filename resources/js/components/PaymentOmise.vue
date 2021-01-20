<template>
  <div>
    <form id="checkoutForm" method="POST" @click.prevent="checkOut">
      <input type="hidden" name="omiseToken" />
      <input type="hidden" name="omiseSource" />
      <button
        type="submit"
        id="checkoutButton"
        class="btn btn-primary"
        style="
          background-color: rgb(0, 123, 255);
          color: whitesmoke;
          padding: 10px 15px;
          border-radius: 10px;
          width: 100%;
        "
      >
        <i class="far fa-credit-card"></i> ชำระเงิน
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  props: ["amount", "purchase_id", "form", "price_all", "museum_id"],
  methods: {
    checkOut() {
      OmiseCard.configure({
        publicKey: "pkey_test_5mlsbndpjaph300tsz3",
      });
      OmiseCard.open({
        amount: this.amount,
        currency: "THB",
        frameLabel: "Influtown",
        // image: "https://sv1.picz.in.th/images/2020/04/21/U1jqbV.png",
        defaultPaymentMethod: "credit_card",
        locale: "th",
        submitLabel: "ชำระเงิน",
        otherPaymentMethods: "credit_card,internet_banking",
        onCreateTokenSuccess: async (nonce) => {
          if (nonce.startsWith("tokn_")) {
            // form.omiseToken.value = nonce;
            const { data } = await axios.post("/api/payment", {
              token: nonce,
              amount: this.amount,
              userId: this.user.id,
              today: this.form.today,
              expiry: this.form.expiry,
              expiry_t: this.form.expiry_t,

              bId: this.form.id,
            });

            let v = this;
            if (data) {
              // this.form.price_all = this.price_all;
              // const result = await axios.post("/api/purchase", this.form);
              if (true) {
                // TODOS:: alert success
                Swal.fire({
                  icon: "success",
                  title: "การชำระเงินสำเร็จ",
                  timer: 1500,
                }).then(async (result) => {
                  // await this.fetchUser();
                  v.closeWindow();
                });
              }
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "มีบางอย่างผิดพลาดการชำระเงินไม่สำเร็จ",
              });
            }
          } else {
            // form.omiseSource.value = nonce;
          }
          // form.submit();
        },
      });
    },
  },
  created() {},
};
</script>

<style></style>
