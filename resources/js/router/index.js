import { createRouter, createWebHistory } from 'vue-router';
// import checkRouteGuard from './routeGuard';
import store from "../store/index"
import axios from "axios"

const routes = [
  {path: '/', component: () => import(`./AppHome.vue`), name: 'Home', meta: {
      guard: 'auth', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
      title: 'Главная', // Название страницы
      headerFooterVisible: true, // Отключить HeaderFooter
    }},
  {path: '/login/', component: () => import(`./AppLogin.vue`), name: 'Login', meta: {
    guard: 'guest', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Авторизация', // Название страницы
    headerFooterVisible: false, // Отключить HeaderFooter
  }},
  {path: '/register/', component: () => import(`./AppRegister.vue`), name: 'Register', meta: {
    guard: 'guest', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Регистрация', // Название страницы
    headerFooterVisible: false, // Отключить HeaderFooter
  }},
  {path: '/create-course/', component: () => import(`./AppCreateCourse.vue`), name: 'AppCreateCourse', meta: {
    guard: 'teacher', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Создание теста', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/get-course/:id', component: () => import(`./AppCourseId.vue`), name: 'AppCourseId', meta: {
    guard: 'teacher', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Создание теста', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/get-fav', component: () => import(`./AppFav.vue`), name: 'AppFav', meta: {
    guard: 'auth', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Создание теста', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  

  {path: '/test/:id', component: () => import(`./AppTest.vue`), name: 'Test', meta: {
    guard: 'auth', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Тестирование', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/login-active/', component: () => import(`./AppLoginActive.vue`), name: 'LoginActive', meta: {
    guard: 'auth', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Авторизация', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/admin/', component: () => import(`./AppAdmin.vue`), name: 'Admin', meta: {
    guard: 'admin', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Тестирование', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/create-test/', component: () => import(`./AppCreateTest.vue`), name: 'AppCreateTest', meta: {
    guard: 'admin', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Создание теста', // Название страницы
    headerFooterVisible: true, // Отключить HeaderFooter
  }},
  {path: '/:has(.*)*', component: () => import(`./AppNotFound.vue`), name: 'Found', meta: {
    guard: 'all', // Защита (guest - для гостей; all - для всех; auth - для авторизированных)
    title: 'Страница не найдена', // Название страницы
    headerFooterVisible: false, // Отключить HeaderFooter
  }},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

let userLoaded = false


router.beforeResolve(async (to, from, next) => {
  // Проверяем, был ли уже загружен пользователь
  if (!userLoaded) {
    try {
      // Загружаем пользователя
      await store.dispatch('login')
      userLoaded = true
    } catch (error) {
      console.error('Error fetching user:', error)
    }
  }
  const user = store.state.user
  // Если пользователь не авторизован
  if (!user) { // Если пытается перейти на маршрут с guard: 'auth'
    if (to.meta.guard === 'auth' || to.meta.guard === "admin" || to.meta.guard === "teacher") { // Перенаправляем на страницу авторизации
      next({ name: 'Login' })
    } else { // Иначе разрешаем переход
      next()
    }
  } else { // Если пользователь авторизован
    if (user.role === 0) { // Если роль пользователя 0 (обычный пользователь)
      if (to.meta.guard === 'admin') { // Запрещаем доступ к маршрутам для админов
        next({ name: 'Home' })
      } else { // Иначе разрешаем переход
        next()
      }
    } else if (user.role === 1) { // Если роль пользователя 1 (админ)
      if (to.name === 'Home') { // Запрещаем доступ к домашней странице
        next({ name: "Admin" })
        // next(false) // Отменяем переход
      } else { // Иначе разрешаем переход
        next()
      }
    } else if (user.role === 2) { // Если роль пользователя 2 (Препод)
      if (to.name === 'Admin') { // Запрещаем доступ к домашней странице
        next({ name: "Home" })
        // next(false) // Отменяем переход
      } else { // Иначе разрешаем переход
        next()
      }
    } else { // Для всех остальных случаев
      if (to.meta.guard === 'guest') { // Перенаправляем на главную страницу
        next({ name: 'Home' })
      } else { // Иначе разрешаем переход
        next()
      }
    }
  }
})

// }  else if (user.role === 0) {
//   // Если пытается перейти на маршрут с guard: 'guest'
//   if (to.meta.guard === 'guest') {
//     // Перенаправляем на главную страницу
//     next({ name: 'Home' })
//   } else {
//     // Иначе разрешаем переход
//     next()
//   }
// // }

// router.beforeEach((to, from, next) => {
//   if (!store.state.user) { // Если пользователь не вошел
//     if (to.meta.guard === 'all') { // Проверяем, что мы не перенаправляем на тот же маршрут
//       next(); // Продолжаем навигацию
//     } else {
//       next({ name: "Login" }); // Перенаправляем на маршрут "Login"
//     }
//   } else if (store.state.user) {
//     if (to,meta.guard === "guest") {
//       next({ name: "Home" })
//     } else {
//       next()
//     }
//   }
// })

// router.beforeEach(checkRouteGuard);

export default router;
