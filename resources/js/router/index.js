import { createRouter, createWebHistory } from  "vue-router";
import AdminLayout from '../components/AdminLayout.vue'
import notFound from '../components/notFound.vue'


import Categories from '../views/categories/Index.vue'
import CategoriesCreate from '../views/categories/Create.vue'
import CategoriesEdit from '../views/categories/Edit.vue'

import faqCategoriesIndex from '../views/faq-category/Index.vue'
import faqCategoriesCreate from '../views/faq-category/Create.vue'
import faqCategoriesEdit from '../views/faq-category/Edit.vue'

import SubCategories from '../views/sub-categories/Index.vue'
import SubCategoriesCreate from '../views/sub-categories/Create.vue'
import SubCategoriesEdit from '../views/sub-categories/Edit.vue'

import faqCategorySubcategoryIndex from '../views/faq-category-subcategory/Index.vue'
import faqCategorySubcategoryCreate from '../views/faq-category-subcategory/Create.vue'
import faqCategorySubcategoryEdit from '../views/faq-category-subcategory/Edit.vue'

import LoginPage from '../views/auth/Login.vue'

import Notification from '../views/notification/Index.vue'
import NotificationCreate from '../views/notification/Create.vue'

import GoverningBodyEdit from '../views/governing-bodies/Edit.vue'


import UsersIndex from '../views/users/Index.vue'
import UsersCreate from '../views/users/Create.vue'
import UsersEdit from '../views/users/Edit.vue'

import PermissionIndex from  '../views/permission/Index.vue/'

import ChangePasswordIndex from '../views/change-password/Index.vue'


import EmailMessage from '../views/email-messages/Index.vue'
import EmailMessageEdit from '../views/email-messages/Edit.vue'

import MessageCategoriesIndex from '../views/messages-categories/Index.vue'
import MessageCategoriesCreate from '../views/messages-categories/Create.vue'
import MessageCategoriesEdit from '../views/messages-categories/Edit.vue'

import resetPasswordEmail from '../views/auth/password/Email.vue'
import ResetPasswordReset from '../views/auth/password/Reset.vue'



import Welcome from '../views/welcome/Index.vue'
import Report from '../views/reports/Index.vue'
import Log from '../views/logs/Index.vue'

import PrivacyPolicy from '../views/privacy-policy/Index.vue'


    const usersRoute = [
        {
            path: '/',
            redirect: '/login'
        },
        {
        path: '/login',
        name: 'Login',
        component: LoginPage
        },
        {
            path: '/users',
            name: 'users.index',
            component: UsersIndex
        },
        {
            path: '/users/create',
            name: 'users.create',
            component: UsersCreate
        },
        {
            path: '/users/:id/edit',
            name: 'users.edit',
            component: UsersEdit
        },
        {
            path: '/permission',
            name: 'permission.index',
            component: PermissionIndex
        },

    ]

    const faqCategoryRoutes = [
        {
            path: '/faq-categories',
            name: 'faqcategory.index',
            component: faqCategoriesIndex
        },
        {
            path: '/faq-categories/create',
            name: 'faqcategory.create',
            component: faqCategoriesCreate
        },
        {
            path: '/faq-categories/:id/edit',
            name: 'faqcategory.edit',
            component: faqCategoriesEdit

        },
    ]

    const categoriesRoutes = [
        {

            path: '/categories',
            name: 'categories.index',
            component: Categories
        },
        {
            path: '/categories/create',
            name: 'categories.create',
            component: CategoriesCreate
        },
        {
            path: '/categories/:id/edit',
            name: 'categories.edit',
            component: CategoriesEdit
        }
    ]

    const subCategoriesRoutes = [
        {

            path: '/sub-categories',
            name: 'subCategories.index',
            component: SubCategories
        },
        {
            path: '/sub-categories/create',
            name: 'subCategories.create',
            component: SubCategoriesCreate
        },
        {
            path: '/sub-categories/:id/edit',
            name: 'subCategories.edit',
            component: SubCategoriesEdit
        }
    ]

    const  faqCategorySubCategoryRoutes=[
        {
            path: '/faq-category-subcategory',
            name: 'faqCategorySubcategory.index',
            component: faqCategorySubcategoryIndex
        },
        {
            path: '/faq-category-subcategory/cteate',
            name: 'faqCategorySubcategory.cteate',
            component: faqCategorySubcategoryCreate
        },
         {
            path: '/faq-category-subcategory/:id/edit',
            name: 'faqCategorySubcategory.edit',
            component: faqCategorySubcategoryEdit
        }

    ]

    const notificationsRoutes = [
        {

            path: '/notifications',
            name: 'notifications.index',
            component: Notification
        },
        {
            path: '/notifications/create',
            name: 'notifications.create',
            component: NotificationCreate
        }
    ]

    const governingBodiesRoutes = [
        {

            path: '/governing-bodies',
            name: 'governing-bodies.index',
            component: GoverningBodyEdit
        },

        {
            path: '/governing-bodies/:id/edit',
            name: 'governing-bodies.edit',
            component: GoverningBodyEdit
        }
    ]
    const changePasswordRoutes = [
        {

            path: '/change-password',
            name: 'change-password.index',
            component: ChangePasswordIndex
        },


    ]

    const emailMessagesRoutes = [
        {

            path: '/email-messages',
            name: 'email-messages.index',
            component: EmailMessage
        },
        {
            path: '/email-messages/:id/edit',
            name: 'email-messages.edit',
            component: EmailMessageEdit
        }
    ]
    const messageCategoriesRoutes = [
        {

            path: '/messages-categories',
            name: 'messages-categories.index',
            component: MessageCategoriesIndex
        },
        {
            path: '/messages-categories/create',
            name: 'messages-categories.create',
            component: MessageCategoriesCreate
        },

        {
            path: '/messages-categories/:id/edit',
            name: 'messages-categories.edit',
            component: MessageCategoriesEdit
        }
    ]
    const forgetPasswordRoutes = [
        {

            path: '/password/reset',
            name: 'password.reset',
            component: resetPasswordEmail
        },
        {
            path: 'api/password/reset',
            name: 'reset.password.reset',
            component: ResetPasswordReset,
        }

    ]

    const welcomeRoutes = [
        {

            path: '/welcome',
            name: 'welcome.index',
            component: Welcome
        }
    ]

    const reportRoutes = [
        {

            path: '/reports',
            name: 'reports.index',
            component: Report
        }
    ]

    const logRoutes = [
        {

            path: '/logs',
            name: 'log',
            component: Log
        }
    ]
    const notFoundRoutes = [
        {
            path:'/:any(.*)*',
            name:'notfound',
            component: notFound
        }
    ]

    const PrivacyPolicyRoutes = [
        {

            path: '/privacy-policy',
            name: 'privacy-policy.index',
            component: PrivacyPolicy
        }
    ]


    const routes = [
        {
            path: '/',
            componenet: AdminLayout,
            children: [
                ...faqCategoryRoutes,
                ...categoriesRoutes,
                ...subCategoriesRoutes,
                ...faqCategorySubCategoryRoutes,
                ...notificationsRoutes,
                ...usersRoute,
                ...governingBodiesRoutes,
                ...changePasswordRoutes,
                ...emailMessagesRoutes,
                ...messageCategoriesRoutes,
                ...forgetPasswordRoutes,
                ...welcomeRoutes,
                ...reportRoutes,
                ...logRoutes,
                ...notFoundRoutes,
                ...PrivacyPolicyRoutes

            ]

        }
    ]




const router = createRouter({
    history: createWebHistory(),
    routes
})
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('access_token'); // Check token
    if (to.meta.requiresAuth && !isAuthenticated) {
        console.log(95656)
      next('/login'); // Redirect to login
    } else {
      next(); // Proceed
    }
  });


export default router
