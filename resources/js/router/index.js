import { createRouter, createWebHistory } from  "vue-router";
import AdminLayout from '../components/AdminLayout.vue'
import faqCategoriesIndex from '../views/faq-category/Index.vue'
import faqCategoriesCreate from '../views/faq-category/Create.vue'
import faqCategoriesEdit from '../views/faq-category/Edit.vue'

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
            path:'/faq-categories/:id/edit',
            name:'faqcategoryedit',
            component:faqCategoriesEdit
        }

    ]

}
]

const router = createRouter({
history: createWebHistory(),
routes
})

export default router
