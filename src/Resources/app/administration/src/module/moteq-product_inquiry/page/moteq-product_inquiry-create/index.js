import template from "./moteq-product_inquiry-create.html.twig";
const { Component, Mixin } = Shopware;

Component.register('moteq-product_inquiry-create', {
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
            isLoading: false,
            processSuccess: false,
            repository: null
        };
    },



    created(){
        this.repository = this.repositoryFactory.create('moteq_product_inquiry');
        this.getProductInquiry();
    },

    methods: {
        getProductInquiry() {
            this.product_inquiry = this.repository.create(Shopware.Context.api);
        },
        onClickSave() {
            this.isLoading = true;

            this.repository
                .save(this.product_inquiry, Shopware.Context.api)
                .then(() => {
                    this.isLoading = false;
                    this.$router.push({ name: 'moteq.product_inquiry.detail', params: { id: this.product_inquiry.id } });
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


