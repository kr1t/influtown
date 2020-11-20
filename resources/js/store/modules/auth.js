import * as types from '../mutation-types'
import axios from 'axios'
import Cookies from 'js-cookie'



// state
export const state = {
  user: {
    id: 'U9dbcc5b44c3f15d67f4ab2de4b0aac2a',
    image_url: '/assets/images/user-de.jpg',
    email: 'test@gmail.com',
    detail: {}
  },
  token: ''
}

// getters
export const getters = {
  user: state => state.user
}

// mutations
export const mutations = {
  [types.FETCH_USER_SUCCESS](state, { user }) {
    state.user = user
  },
  [types.SAVE_LINE_TOKEN](state, { token, remember }) {
    state.token = token
    Cookies.set('line_token', token, { expires: remember ? 365 : null })
  }
}

// actions
export const actions = {
  saveToken({ commit }, payload) {
    commit(types.SAVE_LINE_TOKEN, payload)
  },

  async fetchUser({ commit }, data) {
    try {
      commit(types.FETCH_USER_SUCCESS, { user: data })
    } catch (e) {
      // console.log(e)
    }
  },

  // async checkRegister(user_id) {
  //   // console.log('start check regis')
  //   // console.log(url.registerCheck)
  //   const { data } = await axios.get(`${url.registerCheck}?user_id=${user_id}`).catch(e => {
  //     // console.log(e)
  //     return false
  //   })

  //   // console.log(this.user.id, data)
  // }
}
