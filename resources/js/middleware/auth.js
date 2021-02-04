import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['admin/check']) {
    next({ name: 'login' })
  } else {
    next()
  }
}
