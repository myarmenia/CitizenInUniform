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
        </ul>
    </aside>
</template>

