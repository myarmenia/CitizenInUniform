import { createRouter, createWebHistory } from  "vue-router";
import AdminLayout from '../components/AdminLayout.vue'
import faqCategoriesIndex from '../views/faq-category/FaqCategory.vue'
import faqCategoriesCreate from '../views/faq-category/FaqCategoryCreate.vue'

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
        }

    ]

}
]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
