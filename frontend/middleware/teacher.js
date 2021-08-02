export default function ({ store, redirect }) {
  const teacherRole = 'teacher'
  if (store.state.auth.loggedIn) {
    if (store.state.auth.user.roles.includes(teacherRole) && (store.state.auth.user.teacher_info === null || store.state.auth.user.user_info === null)) {
      return redirect('/about')
    }
  } else {
    return redirect('/')
  }
}
