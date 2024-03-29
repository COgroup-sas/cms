import swal from 'sweetalert2';
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = require('jquery');
  window.Popper = require('popper.js').default;

  //Materialize-css
  window.M = require('materialize-css/dist/js/materialize.min');

  require('bootstrap');
  require('moment');
  window.Chart = require('chart.js');
  require('gijgo');
  require('./plugins/bootstrap-notify');
  require('./plugins/jquery.sharrre');
  require('inputmask');

  //datatables
  require( 'jszip' );
  require( 'pdfmake' );
  require( 'datatables.net-bs4' );
  require( 'datatables.net-autofill-bs4' );
  require( 'datatables.net-buttons-bs4' );
  require( 'datatables.net-buttons/js/buttons.colVis.js' );
  require( 'datatables.net-buttons/js/buttons.flash.js' );
  require( 'datatables.net-buttons/js/buttons.html5.js' );
  require( 'datatables.net-buttons/js/buttons.print.js' );
  require( 'datatables.net-colreorder-bs4' );
  require( 'datatables.net-fixedcolumns-bs4' );
  require( 'datatables.net-fixedheader-bs4' );
  require( 'datatables.net-keytable-bs4' );
  require( 'datatables.net-responsive-bs4' );
  require( 'datatables.net-rowgroup-bs4' );
  require( 'datatables.net-rowreorder-bs4' );
  require( 'datatables.net-scroller-bs4' );
  require( 'datatables.net-searchpanes-bs4' );
  //require( 'datatables.net-select-bs4' );
  //require('mdbootstrap');
  require('mdbootstrap/js/addons/datatables2.min');
  require('mdbootstrap/js/addons/datatables-select.min');
  require('mdbootstrap/js/addons/datatables-select2.min');
  require('mdbootstrap/js/addons/directives.min');
  require('mdbootstrap/js/addons/flag.min');
  require('mdbootstrap/js/addons/rating.min');
  require('select2');
  window.Swal = swal;

  require('./validation');
  require('./plugins/tagsinput');
  require('./plugins/verticalmenu');
  require('./cog');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
