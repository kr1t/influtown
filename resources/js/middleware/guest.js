import store from '~/store'

export default (to, from, next) => {
  if (store.getters['admin/check']) {
    next({ name: 'home' })
  } else {
    next()
  }
}
