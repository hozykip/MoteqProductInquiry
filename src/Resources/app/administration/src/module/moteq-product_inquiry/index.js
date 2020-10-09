import "./page/moteq-product_inquiry-list";
import "./page/moteq-product_inquiry-detail";
import "./page/moteq-product_inquiry-create";
import enGB from "./snippet/de-DE.json";
import deDe from "./snippet/en-GB.json";



Shopware.Module.register('moteq-product_inquiry',{
    type: 'plugin',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',
    title: 'moteq-product_inquiry.general.mainMenuItemGeneral',
    description: 'moteq-product_inquiry.general.descriptionTextModule',
    routes: {
        list: {
            component: 'moteq-product_inquiry-list',
            path: 'list'
        },
        detail: {
            component: 'moteq-product_inquiry-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'moteq.product_inquiry.list'
            }
        },
        create: {
            component: 'moteq-product_inquiry-create',
            path: 'create',
            meta: {
                parentPath: 'moteq.product_inquiry.list'
            }
        },
    },
    navigation: [{
        label: 'moteq-product_inquiry.general.mainMenuItemGeneral',
        color: '#ff3d58',
        path: 'moteq.product_inquiry.list',
        icon: 'default-shopping-paper-bag-product',
        position: 100
    }],
    settingsItem: {
        group: 'system',
        to: 'moteq.product_inquiry.list',
        icon: 'default-shopping-paper-bag-product'
    },
    snippets: {
        'en-GB' : enGB,
        'de-DE' : deDe
    }
});
