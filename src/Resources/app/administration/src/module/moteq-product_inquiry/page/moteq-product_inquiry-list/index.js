import template from "./moteq-product_inquiry-list.html.twig";

Shopware.Component.register('moteq-product_inquiry-list', {
    template,
    metaInfo(){
        return {
            title: this.$createTitle()
        }
    },
    inject:[
        'repositoryFactory'
    ],
    data(){
        return {
            repository: null,
            product_inquiries: null
        }
    },
    created(){
        const Criteria = Shopware.Data.Criteria;
        this.repository = this.repositoryFactory.create('moteq_product_inquiry');

        this.repository
            .search(new Criteria(), Shopware.Context.api)
            .then((result)=>{
                this.product_inquiries = result;
            })

    },
    computed: {
        columns() {
            return [{
                property: 'email',
                dataIndex: 'email',
                label: this.$tc('moteq-product_inquiry.list.columnEmail'),
                routerLink: 'swag.bundle.detail',
                inlineEdit: 'string',
                allowResize: true,
                primary: true
            }, {
                property: 'inquiry',
                dataIndex: 'inquiry',
                label: this.$tc('moteq-product_inquiry.list.columnInquiry'),
                inlineEdit: 'number',
                allowResize: true
            }, {
                property: 'response',
                dataIndex: 'response',
                label: this.$tc('moteq-product_inquiry.list.columnResponse'),
                inlineEdit: 'string',
                allowResize: true
            }];
        }
    },
});
