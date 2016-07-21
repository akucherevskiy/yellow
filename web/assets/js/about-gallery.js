export default (function aboutGallery($) {
  const owlCarousel = $('.owl-carousel');
  const galleryContent = $('#galleryCarousel');
  const gallerySelector = $('.about-gallery-sel');
  const ACTIVE_CLASS = 'is-active';
  const owlOptions = {
    items: 3,
    center: true,
    loop: true
  };

  owlCarousel.owlCarousel(owlOptions);

  gallerySelector.on('click', function () {
    gallerySelector.removeClass(ACTIVE_CLASS);
    const galleryId = $(this).data('gallery-id');
    $(this).addClass(ACTIVE_CLASS).siblings().remove(ACTIVE_CLASS);

    $(`#${galleryId}`).addClass(ACTIVE_CLASS).siblings().removeClass(ACTIVE_CLASS);

    $('body').animate({
      scrollTop: $(galleryContent).offset().top
    }, 1000);
    
  });
}($));
