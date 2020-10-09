// src/Resources/app/storefront/src/main.js

// import all necessary storefront plugins
import MoteqFePlugin from './moteq-fe-plugin/moteq-fe-plugin';

// register them via the existing PluginManager
const PluginManager = window.PluginManager;
PluginManager.register('MoteqFePlugin', MoteqFePlugin, '#moteq-product-inquiry-tab-pane');
