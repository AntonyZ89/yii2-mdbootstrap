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

// Initialize inputs after update
$(document).on('pjax:success', '[data-pjax-container]', function () {
  mdb_helper.input.init();
});

// Initialize inputs after insert
$('[data-dynamicform]').on('afterInsert', function (e, item) {
  mdb_helper.input.init();
});

// force label move up
$('[data-plugin-inputmask]').blur(function () {
  const self = $(this);

  if (self.val()) {
    self.addClass('active')
  }
})