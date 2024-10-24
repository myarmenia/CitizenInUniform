import { createRouter, createWebHistory } from  "vue-router";
import faqCategoriesIndex from '../components/faqCategories/Index.vue'
import AdminLayout from '../components/AdminLayout.vue'

const routes = [
{
    path:'/',
    componenet:AdminLayout,
    chinlren:[
        {
            path:'/faq-categories',
            name:'faqCategories.index',
            component:faqCategoriesIndex
        }

    ]

}
]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
