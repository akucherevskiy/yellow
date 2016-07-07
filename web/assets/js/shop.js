export default (function shop() {
  const ACTIVE_CLASS = 'is-active';
  const $shopNavItem = $('.shop-nav-cat');
  const $shopItemPanes = $('.shop-item-pane');

  function toggleState() {
    Array.prototype.slice.call(arguments)
      .forEach((elem)=>
        elem.addClass(ACTIVE_CLASS)
            .siblings()
            .removeClass(ACTIVE_CLASS));
  }

  $shopNavItem.on('click', function (e) {
    e.preventDefault();

    const id = $(this).attr('href').split('#')[1];

    toggleState($(this), $('#' + id));

  });
  
}());
