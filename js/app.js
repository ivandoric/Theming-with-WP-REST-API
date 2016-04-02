var App = Vue.extend({});

var postList = Vue.extend({
    template:'#post-list-template',
    data: function(){
        return {
            posts: '',
            nameFilter: '',
            categoryFilter: '',
            categories: ''
        }
    },

    ready: function(){
        posts = this.$resource('/wp-json/wp/v2/posts?per_page=20');
        categories = this.$resource('/wp-json/wp/v2/categories');

        posts.get(function(posts){
            this.$set('posts', posts);
        })

        categories.get(function(categories){
            this.$set('categories', categories);
        })
    }
})



var router = new VueRouter();

router.map({
    '/':{
        component: postList
    }
});

router.start(App, '#app');