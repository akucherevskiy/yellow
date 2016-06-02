export default (function makeOrder() {
  const orderBtn = $('#orderBtn');

  orderBtn.on('click', function (event) {
    event.preventDefault();

    $.post().then(()=> {
      
    });
  });
})()
