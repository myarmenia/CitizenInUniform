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


    const faqCategoryRoutes = [
        {
            path: '/faq-categories',
            name: 'faqcategory',
            component: faqCategoriesIndex
        },
        {
            path: '/faq-categories/create',
            name: 'faqcategorycreate',
            component: faqCategoriesCreate
        },
        {
            path: '/faq-categories/:id/edit',
            name: 'faqcategoryedit',
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

    const routes = [
        {
            path: '/',
            componenet: AdminLayout,
            children: [
                ...faqCategoryRoutes,
                ...categoriesRoutes,
                ...subCategoriesRoutes
            ]

        }
    ]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
