import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['admin/check'] && store.getters['admin/token']) {
    try {
      await store.dispatch('admin/fetchUser')
    } catch (e) { }
  }

  next()
}
