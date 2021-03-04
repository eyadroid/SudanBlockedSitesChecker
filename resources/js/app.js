require('./bootstrap');
window.Vue = require('vue');

// models
import Website from './models/Website';

// components
Vue.component('website-ad-component', require('./components/WebsiteAddComponent.vue').default);
Vue.component('website-component', require('./components/WebsiteComponent.vue').default);

const app = new Vue({
    el: '#app',
    data: {
        // data
        websitesList: [],
        errors: {
            "websiteName": [],
            "websiteUrl": []
        },

        // inputs
        search: '',
        addedName: '',
        addedUrl: '',
        
        // app state
        showAddComponent: false,
        loading: true,
        adding: false,
        checkingwebsite: 0
    },
    methods: {
        toggleAdd: function() {
            this.showAddComponent = !this.showAddComponent;
        },
        async get() {
            if (!this.loading)
                this.loading = true;
            const { data } = await window.axios.get('/api/all');
            this.loading = false;
            data.data['websites'].forEach(website => this.websitesList.push(new Website(website)));
        },
        add: async function() {
            this.errors = {
                "websiteName": [],
                "websiteUrl": []
            };

            if (!this.addedName) this.errors['websiteName'].push("required");
            if (!this.addedUrl) this.errors['websiteUrl'].push("required");
            if (this.addedUrl && !validURL(this.addedUrl)) this.errors['websiteUrl'].push("unvaild");

            if (this.errors["websiteName"].length > 0 || this.errors["websiteUrl"].length > 0) return;

            this.adding = true;
            let websiteData = {
                name: this.addedName,
                url: this.addedUrl
            }
            if (websiteData.url.substring(0,4) != "http") websiteData.url = "http://"+websiteData.url;

            try {
                const { data } = await window.axios.post('/api/add', websiteData);
    
                this.adding = false;
                this.addedName = "";
                this.addedUrl = "";
    
                alert("Added Successfully");
            }
            catch (e) {
                if (e.message == "Request failed with status code 422") {
                    this.adding = false;
                    this.addedName = "";
                    this.addedUrl = "";
                    alert("Added Successfully");
                }

                this.adding = false;
            }
        },
        async checkWebsiteStatus(website) {
            if (!this.checkingwebsite) {
                this.checkingwebsite = website.id;
                const { data } = await window.axios.post('/api/website/'+website.id+"/check-status");
    
                if (data.success == true) {
                    website.last_request = data.data.lastRequest;
                }
                else {
                    alert("Error");
                }
                this.checkingwebsite = 0;
            }
        },
        async saveWebsiteStatus(website, status) {

        },
        async addWebsite() {

        }
    },
    computed: {
        filteredWebsites() {
          return this.websitesList.filter(website => website.name.toLowerCase().includes(this.search.toLowerCase()) || website.url.toLowerCase().includes(this.search.toLowerCase())
          )
        }
    },
    created() {
        this.get();
      }
});


function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
      '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
      '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
      '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
      '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(str);
}