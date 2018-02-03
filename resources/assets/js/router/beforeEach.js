// import vuex from '../vuex'

// const needAuth = route => route.meta.auth === true;

const beforeEach = (to, from, next) => {
  // if (to.name == 'auth.login' || to.name == 'auth.account.login') {
  //   $('body').removeClass('bg-default').addClass('bg-white')
  // } else {
  //   $('body').removeClass('bg-white').addClass('bg-default')
  // }

  // vuex.dispatch('checkUserToken')
  //   .then((token) => {
  //     if (to.path.indexOf('dashboard') > 0) {
  //       return next({ name: 'home' })
  //     }

  //     return next()
  //   }).catch((err) => {
  //     if (needAuth(to)) {
  //       // No token, or it is invalid
  //       return next({ name: 'auth.account.login' }) // redirect to login
  //     }
  //     next()
  //   });
  next();
};

export default beforeEach
