export default (function addToBasket() {
  const addItemBtn = $('#shopItemOrderBtn');
  const body = $('body');

  addItemBtn.on('click', function () {
    body.addClass('dialog-enabled').append(`
      <div class="backdrop"></div>
      <div class="dialog">
        <header class="dialog-header">
          <button class="dialog-close">&times;</button>
        </header>
        <div class="dialog-body">
        <img src="/assets/img/icons/basket-large.png" alt="" class="dialog-basketImg">
          <p class="dialog-text">Product added to cart</p>
          <div class="u-textCenter">
            <a class="link dialog-button" href="shop.html">Continue shopping</a>
            <a class="button dialog-button" href="#">GO TO BASKET</a>
          </div>
        </div>
      </div>
    `);
  });
  
  $(document).on('click', '.dialog-close', function () {
    $('.dialog, .backdrop').remove();
    body.removeClass('dialog-enabled');
  });
})();
