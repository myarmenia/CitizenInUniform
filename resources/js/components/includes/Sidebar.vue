
<script setup>
import {me} from "../../me";
import { useRouter } from 'vue-router';

const router = useRouter();
const {userMe} = me(router)

</script>
<template>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('categories.'))}" :to="{name: 'categories.index'}">
                    <i class="bi bi-menu-app"></i>
                    <span>Մենյուի բաժիններ</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link   :to="{name: 'subCategories.index'}"  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('subCategories.'))}">
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Մենյուի ենթաբաժիններ</span>
                </router-link>
            </li>

            <li class="nav-item">

                <router-link
                    class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqcategory.'))}"
                    :to="{name: 'faqcategory.index'}"
                 >
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ կատեգորիա</span>

                </router-link>

            </li>
            <li class="nav-item">
                <router-link class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqCategorySubcategory.'))}"
                    :to="{name: 'faqCategorySubcategory.index'}">
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ  ենթակատեգորիա</span>

                </router-link>
            </li>

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('notifications.'))}" :to="{name: 'notifications.index'}">
                    <i class="bi bi-bell"></i>
                    <span>Ծանուցումներ</span>
                </router-link>
            </li>

            <li v-for = "role in userMe.roles" :key="role.id" class="nav-item">
                <router-link v-if="role.name=='super_admin' || role.name=='admin'"  class="nav-link" :class="{'collapsed': !($route.name && $route.name.startsWith('users.index.'))}" :to="{name: 'users.index'}">
                    <i class="bi bi-bell"></i>
                    <span>Օգտատերեր </span>

                </router-link>
            </li>

        </ul>
        <!-- {{ userMe.roles }} -->
    </aside>
</template>

