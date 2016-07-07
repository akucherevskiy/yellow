export default (function lectoriumNews($) {
  const lectoriumWrapper = $('.lectorium .square');
  let item = $('.lectorium-item-card');
  let mainPostWrapper = $('.lectorium-inner');
  let mainPostImg = $('.lectorium-inner-img');
  let mainPostInner = $('.lectorium-inner-description');
  let mainPostDateDay = $('.lectorium-inner-date-day');
  let mainPostDateMonth = $('.lectorium-inner-date-month');
  let mainPostTitle = $('.lectorium-inner-ttl');
  let mainPostTxt = $('.lectorium-inner-txt');

  item.on('click', function ($event) {
    $event.preventDefault();
    mainPostImg.attr('src', $(this).find('.item-card-img-large').attr('src'));
    mainPostTitle.html($(this).find('.item-card-upperTxt').text());
    mainPostDateDay.html($(this).find('.item-card-date-day').text());
    mainPostDateMonth.html($(this).find('.item-card-date-month').text());
    mainPostTxt.html($(this).find('.item-card-txt').text());
    $(window).scrollTop($(lectoriumWrapper).offset().top);
  });
}($));
