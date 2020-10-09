import template from "./moteq-product_inquiry-detail.html.twig";

const { Component, Mixin } = Shopware;

Component.register("moteq-product_inquiry-detail",{
    template,
    metaInfo(){
        return {
            title: this.$createTitle()
        }
    },

    inject:[
        'repositoryFactory'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            product_inquiry: null,
            product: null,
            isLoading: false,
            processSuccess: false,
            repository: null,
            product_repository: null
        };
    },



    created(){
        this.repository = this.repositoryFactory.create('moteq_product_inquiry');
        this.product_repository = this.repositoryFactory.create('product');
        this.getProductInquiry();
    },

    methods: {
        getProductInquiry() {
            this.repository
                .get(this.$route.params.id, Shopware.Context.api)
                .then((entity) => {
                    this.product_inquiry = entity;
                })
                .then(()=>{
                    this.getProduct(this.product_inquiry.productId)
                });
        },
        getProduct(productId) {
            this.product_repository
                .get(productId, Shopware.Context.api)
                .then((entity) => {
                    this.product = entity;
                    console.log(entity.name)
                });
        },

        onClickSave() {
            this.isLoading = true;

            this.repository
                .save(this.product_inquiry, Shopware.Context.api)
                .then(() => {
                    this.getProductInquiry();
                    this.isLoading = false;
                    this.processSuccess = true;
                }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    title: this.$tc('moteq-product_inquiry.detail.errorTitle'),
                    message: exception
                });
            });
        },

        saveFinish() {
            this.processSuccess = false;
        },
    }

});
