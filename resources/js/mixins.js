import { mapActions, mapGetters } from 'vuex'
import axios from 'axios'

export default {
  data() {
    return {
      scrolled: false,
      windowWidth: 0,
      windowHeight: 0
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      isLoading: 'loading/isLoading'
    })
  },
  mounted() {
    // this.$nextTick(function() {
    //   window.addEventListener('resize', this.getWindowWidth)
    //   window.addEventListener('resize', this.getWindowHeight)
    //   // Init
    //   this.getWindowWidth()
    //   this.getWindowHeight()
    // })
  },
  methods: {
    ...mapActions({
      fethUser: 'auth/fetchUser',
      saveToken: 'auth/saveToken',
      loadingStart: 'loading/loadingStart',
      loadingStop: 'loading/loadingStop',
      checkRegister: 'auth/checkRegister'
    }),
    nFormat(n) {
      const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }
      const formatted = Number(n).toLocaleString('en', options)
      return formatted
    },
    toTop(){
      document.body.scrollTop = document.documentElement.scrollTop = 0;
    },
    openWindow(url) {
      this.$liff.openWindow({
        url
      })
      // alert(url)
    },

    closeWindow(text = false) {
      if (text) {
        this.$liff.sendMessages([
          {
            type: 'text',
            text: text
          }
        ])
      }
      this.$liff.closeWindow()
    },

    getLiffKey(name){
      try {
        return window.config.liff.find(el=> el.name == name).key
      } catch (error) {
        return name
      }
    },
    async initializeLiff(name, getProfile, pageName) {
      // console.log('start liff')

      let myLiffId = this.getLiffKey(name)
      const { isLocal } = window.config
      if (isLocal) {
        return true
      }
      this.loadingStart()
      let _this = this

      // let isInClient = this.$liff.isInClient()
      // if (!isInClient) {
      //   this.$router.push({ name: 'error406' })
      //   _this.loadingStop()

      //   return false
      // }

      try {
        await new Promise.all(
          await this.$liff.init(
            { liffId: myLiffId },
            async () => {
              if (_this.$liff.isLoggedIn()) {
                await _this.getProfile(getProfile, pageName)
                _this.loadingStop()
                return true
              } else {
                _this.$liff.login()
                return false
              }
            },
            err => alert(err.message)
          )
        )
      } catch (error) {}
      this.loadingStop()

      return true
    },
    async getProfile(getProfile, pageName) {
      let _this = this
      const profile = await this.$liff.getProfile()
      console.log(profile)

      let usr = false
      // if (getProfile) {
      //   usr = await axios.get(path.user.getProfile(profile.userId))
      // }


      try {
        await this.fethUser({
          id: profile.userId,
          name: profile.displayName,
          status: profile.statusMessage,
          image_url: profile.pictureUrl,
          email: _this.$liff.getDecodedIDToken().email,
          token: _this.$liff.getAccessToken(),
          detail: usr ? usr.data.result.user : {}
        })
      } catch (error) {}
    }
  }
}
