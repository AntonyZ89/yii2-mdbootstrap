$('.sidebar-right').each(function () {
  const self = $(this);

  const $div = $('<div class="exit text-end"></div>');
  $div.append('<button class="btn-close"></button>')

  self.prepend($div);
});

$(document).on('click', '.sidebar-right > .exit', function () {
  $(this).closest('.sidebar-right').removeClass('show');
})
