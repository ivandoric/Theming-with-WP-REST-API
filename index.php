<?php get_header(); ?>

    <div class="white-wrap">
        <div id="app">

            <router-view></router-view>

        </div>
    </div>


<template id="post-list-template">

    <header class="main-header">
        <img class="hero" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="">    
    </header>

    <div class="filter-bar">

        <div class="container">
            <a v-on:click="openFilter" class="btn-filter open" v-if="filterBtnOpen"><span class="icon-filter"></span> Open filter</a>
            <a v-on:click="closeFilter" class="btn-filter close" v-if="filterBtnClose"><span class="icon-filter"></span> Close filter</a>
        </div>
        
        <div class="filter-wrap" v-if="showFilter" transition="filter">
            <div class="container">
                <div class="by-name">
                    <h4>Filter by Name</h4>
                    <input type="text" name="" v-model="nameFilter">
                </div>
            
                <div class="by-category clearfix">
                    <h4>Filter by Category</h4>
            
                    <div class="radio-wrap">
                        <input type="radio" value="" v-model="categoryFilter">
                        <label>All</label>
                    </div>
            
                    <div class="radio-wrap" v-for="category in categories" v-if="category.name != 'Uncategorized'">
                        <input type="radio" value="{{ category.id }}" v-model="categoryFilter">
                        <label>{{ category.name }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="post-list">
            <article v-for="post in posts | filterBy nameFilter in 'title' | filterBy categoryFilter in 'categories'" class="post">
                <img v-bind:src="post.fi_300x180">
                <div class="post-content">
                    <h2>{{ post.title.rendered }}</h2>
                    <small v-for="category in post.cats">
                        {{ category.name }}
                    </small>
                </div>
            </article>
        </div>
    </div>

</template>

<?php get_footer(); ?>