<template>
  <div class="row">
    <div class="col-lg-8 m-auto">

      <card title="Register">
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
              <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="name" placeholder="ชื่อ">
              <has-error :form="form" field="name" />
            </div>
              <div class="col-6">
              <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name" placeholder="นามสกุล">
              <has-error :form="form" field="last_name" />
            </div>
          </div>

       <div class="form-group row">
            <div class="col-6">
              <input v-model="form.tel" :class="{ 'is-invalid': form.errors.has('tel') }" class="form-control" type="text" name="name" placeholder="เบอร์โทรศัพท์">
              <has-error :form="form" field="tel" />
            </div>
              <div class="col-6">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="text" name="last_name" placeholder="อีเมล">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <div class="form-group">
              <input v-model="form.zipcode" :class="{ 'is-invalid': form.errors.has('zipcode') }" class="form-control" type="text" name="name" placeholder="รหัสไปรษณีย์">
              <has-error :form="form" field="zipcode" />
          </div>

               <div class="form-group">
              <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-control" type="text" name="name" placeholder="ที่อยู่">
              <has-error :form="form" field="address" />
          </div>

               <div class="form-group">
              <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="name" placeholder="อำเภอ">
              <has-error :form="form" field="city" />
          </div>

                 <div class="form-group">
              <input v-model="form.province" :class="{ 'is-invalid': form.errors.has('province') }" class="form-control" type="text" name="name" placeholder="จังหวัด">
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
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: 'ลงทะเบียน'}
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'home' })
      }
    }
  },
  async created() {
    await this.initializeLiff('register', true, 'ลงทะเบียน')
  },
}
</script>
