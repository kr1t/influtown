import * as types from '../mutation-types'

// state
export const state = {
  isLoading: false
}

// getters
export const getters = {
  isLoading: state => state.isLoading
}

// mutations
export const mutations = {
  [types.LOADING](state, loading) {
    state.isLoading = loading
  }
}

// actions
export const actions = {
  loadingStart({ commit }) {
    commit(types.LOADING, true)
  },
  loadingStop({ commit }) {
    commit(types.LOADING, false)
  }
}
