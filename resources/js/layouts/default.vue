<template>
  <div class="main-layout">

       <loading
        :active.sync="isLoading"
        :can-cancel="false"
        color="#fff"
        :is-full-page="true"
        loader="dots"
        background-color="#80171A"
        :opacity="1"
      ></loading>


    <navbar />

    <div>
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Loading
  }
}
</script>\

