require('./bootstrap');

// require('alpinejs');


import Alpine from 'alpinejs';

Alpine.data('demo', () => ({
    open: false,

    toggle() {
        this.open = !this.open
    }
}));

window.Alpine = Alpine;

// should be last
Alpine.start();
