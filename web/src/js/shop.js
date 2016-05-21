export default (function shop() {
  const shopNavItem = $('.shop-nav-cat');
  const shopItems = $('#shopItems');

  shopNavItem.on('click', function (e) {
    const ACTIVE_CLASS = 'is-active';
    e.preventDefault();
    shopItems.fadeOut(50);
    const catId = $(this).data('cat-id');
    $.get(`/partials/shop/${catId}.html`)
      .then((response)=>
        shopItems.fadeOut(10, ()=>
          shopItems.empty().html(response).fadeIn(500)));

    $(this)
      .addClass(ACTIVE_CLASS)
      .siblings()
      .removeClass(ACTIVE_CLASS);
  });
}());
