const footerHeight = $('footer').outerHeight() || 0;
const mainNavbarHeight = $('#main-navbar').outerHeight() || 0;
const windowHeight = window.innerHeight;
const containerHeight = windowHeight - footerHeight - mainNavbarHeight;

$('body:not(.login) > main > .container, main > .container-fluid').css('min-height', containerHeight);

const mdb_helper = {
  input: {
    init() {
      document.querySelectorAll('.form-outline').forEach((formOutline) => {
        new mdb.Input(formOutline).init();
      });
    }
  }
}

/**
 * @EVENTS
 */

$(document).on('pjax:success', '[data-pjax-container]', function () {
  mdb_helper.input.init();
});

$('[data-dynamicform]').on('afterInsert', function (e, item) {
  mdb_helper.input.init();
});
