import Vue from 'vue'
import vUploader from 'v-uploader'

// v-uploader plugin global config
const uploaderConfig = {
  // file uploader service url
  uploadFileUrl: '/api/image/upload',
  // file delete service url
  deleteFileUrl: 'http://xxx/upload/deleteUploadFile',
  // set the way to show upload message(upload fail message)
  showMessage: (vue, message) => {
    //using v-dialogs to show message
    vue.$dlg.alert(message, { messageType: 'error' })
  }
}

// install plugin with options
Vue.use(vUploader, uploaderConfig)
