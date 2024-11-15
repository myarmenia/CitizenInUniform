<script setup>
import { useRouter } from "vue-router";
import { useGoverningBodies } from "../../sidebar";
import {me} from "../../me";

const router = useRouter();

const { governingBodies } = useGoverningBodies(router);
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
                <router-link :to="{name: 'governing-bodies.index'}" class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" aria-expanded="false" :class="{'collapsed': !($route.name && $route.name.startsWith('governing-bodies.'))}">
                <i class="bi bi-bank"></i><span>Պետական կառավարման մարմիններ</span><i class="bi bi-chevron-down ms-auto"></i>
                </router-link>

                <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li v-for="governingBody in governingBodies">
                        <router-link
                                :class="{'active': $route.name === 'governing-bodies.edit' && $route.params.id && $route.params.id == governingBody.id}"
                                :to="{name: 'governing-bodies.edit', params: { id: governingBody.id }}">
                            <i class="bi bi-circle"></i><span>{{governingBody.name}}</span>
                        </router-link>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('notifications.'))}" :to="{name: 'notifications.index'}">
                    <i class="bi bi-bell"></i>
                    <span>Ծանուցումներ</span>
                </router-link>
            </li>

            <li v-for = "role in userMe.roles" :key="role.id" class="nav-item">
                <router-link v-if="role.name=='super_admin' || role.name=='admin'"  class="nav-link" :class="{'collapsed': !($route.name && $route.name.startsWith('users.index.'))}" :to="{name: 'users.index'}">
                    <i class="bi bi-person"></i>
                    <span>Օգտատերեր </span>

                </router-link>
            </li>

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('email-messages.'))}" :to="{name: 'email-messages.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրություն</span>
                </router-link>
            </li>
            <li class="nav-item">

                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('message_categories.'))}" :to="{name: 'message_categories.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրության կատեգորիաներ</span>
                </router-link>
            </li>
            <li>
                <a class="nav-link collapsed"  href="https://citizenw.trigger.ltd/chatpage" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-chat-left-dots"></i>
                    <span>Կենդանի զրույց</span>
                </a>
            </li>

        </ul>
        <!-- {{ userMe.roles }} -->
    </aside>
</template>

