import { createRouter, createWebHistory } from  "vue-router";
import AdminLayout from '../components/AdminLayout.vue'

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

import PasswordResetIndex from '../views/change-password/Index.vue'



    const usersRoute = [
        {
            path: '/',
            redirect: '/users/login'
        },
        {
        path: '/users/login',
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
        }
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
        {

            path: '/password/reset',
            name: 'password-reset.index',
            component: PasswordResetIndex
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
            ]

        }
    ]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
