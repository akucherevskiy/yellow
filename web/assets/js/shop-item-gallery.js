export default (function shopItemGallery() {
  const galleryItem = $('.shopItem-gallery-carouselImg');
  const activeGalleryItem = $('.shopItem-gallery-mainImg');
  const ACTIVE_CLASS = 'is-active';

  galleryItem.on('click', function () {
    $(this).parent()
      .addClass(ACTIVE_CLASS)
      .siblings()
      .removeClass(ACTIVE_CLASS);
    const src = $(this).attr('src');
    activeGalleryItem.attr('src', src);
  });
})();
