var App = Vue.extend({});

var postList = Vue.extend({
    template:'#post-list-template',
    data: function(){
        return {
            posts: '',
            nameFilter: '',
            categoryFilter: '',
            categories: '',
            showFilter: false,
            filterBtnOpen: true,
            filterBtnClose: false,
            post:'',
            show: false,
            allPages: '',
            prev_page: '',
            next_page: '',
            currentPage: '',
            loading: ''
        }
    },

    ready: function(){
        
        categories = this.$resource('/wp-json/wp/v2/categories');
        categories.get(function(categories){
            this.$set('categories', categories);
        })

        this.getPosts(1);
    },

    methods: {

        getPosts: function(pageNumber){
            posts = '/wp-json/wp/v2/posts?filter[posts_per_page]=6&page=' + pageNumber;

            this.currentPage = pageNumber;

            this.$set('loading', true);
            
            this.$http.get(posts).then(function(response){
                this.$set('posts', response.data);
                this.makePagination(response);

                this.$set('loading', false);
            });
        },

        makePagination: function(data){
            this.$set('allPages', data.headers('X-WP-TotalPages'));

            //Setup prev page
            if(this.currentPage > 1){
                this.$set('prev_page', this.currentPage - 1);
            } else {
                this.$set('prev_page', null);
            }

            // Setup next page
            if(this.currentPage == this.allPages){
                this.$set('next_page', null);
            } else {
                this.$set('next_page', this.currentPage + 1);
            }
            

        },

        getThePost: function(id){
            var posts = this.posts;

            this.$set('show', true);

            function filterPosts(el){
                return el.id == id;
            }

            this.$set('post', posts.filter(filterPosts));
        },
        
        closePost: function(){
            this.$set('show', false);
        },

        openFilter: function(){
            this.$set('showFilter', true);
            this.$set('filterBtnOpen', false);
            this.$set('filterBtnClose', true);
        },

        closeFilter: function(){
            this.$set('showFilter', false);
            this.$set('filterBtnOpen', true);
            this.$set('filterBtnClose', false);
        }
    }
})


var singlePost = Vue.extend({
    template: '#single-post-template',

    route:{
        data: function(){
            this.$http.get('/wp-json/wp/v2/posts/' + this.$route.params.postID, function(post){
                this.$set('post', post);
            })
        }
    }

});

var movieList = Vue.extend({
    template: '#movie-list-template',
    data: function(){
        return {
            movies: '',
        }
    },

    route:{
        data: function(){
            this.$http.get('/wp-json/wp/v2/movies', function(movies){
                this.$set('movies', movies);

                console.log(JSON.stringify(movies));
            })
        }
    }

});



var router = new VueRouter();

router.map({
    '/':{
        component: postList
    },
    'post/:postID':{
        name:'post',
        component: singlePost
    },
    'movies':{
        component: movieList
    }
});

router.start(App, '#app');