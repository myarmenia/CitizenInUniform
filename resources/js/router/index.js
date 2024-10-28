import { createRouter, createWebHistory } from  "vue-router";
import AdminLayout from '../components/AdminLayout.vue'
import faqCategoriesIndex from '../views/faq-category/FaqCategory.vue'
import faqCategoriesCreate from '../views/faq-category/FaqCategoryCreate.vue'

import Categories from '../views/categories/Index.vue'
import CategoriesCreate from '../views/categories/Create.vue'
import CategoriesEdit from '../views/categories/Edit.vue'



const routes = [
{
    path:'/',
    componenet:AdminLayout,
    children:[
        {
            path:'/faq-categories',
            name:'faqcategory',
            component:faqCategoriesIndex
        },
        {
            path:'/faq-categories/create',
            name:'faqcategorycreate',
            component:faqCategoriesCreate
        },
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

}
]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
